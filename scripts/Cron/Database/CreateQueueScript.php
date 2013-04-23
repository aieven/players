<?php
    /**
        Copies files from database to redis queue
     */
    namespace Players\Script\Cron\Database;

    use Players\Utilities\Timer;
    use Players\Utilities\Debug;

    class CreateQueueScript extends \Players\Script\Base {
        private $dbStep = 10000;

        const SQL_SELECT_PLAYERS = <<<SQL
    -- SQL_SELECT_PLAYERS
    SELECT vk_id, first_name
      FROM {{ t("players") }} USE INDEX( PRIMARY )
      WHERE vk_id <= {{ i(top_limit) }}
      AND vk_id > {{ i(bottom_limit) }}
      ORDER BY vk_id

SQL;
        const SQL_SELECT_COUNT_PLAYERS = <<<SQL
    -- SQL_SELECT_COUNT_PLAYERS
    SELECT count( * )
      FROM {{ t("players") }}
      USE INDEX( PRIMARY )
SQL;

        public function run(){
            $Timer = Timer::instance();
            $startTime = $Timer->micro();

            $Db = $this->db( 'main' );
            $count = $Db->selectField( self::SQL_SELECT_COUNT_PLAYERS , array());

            $RedisModel = new \Players\Model\Redis\Queue( 'players' );
            for( $i = 0; $i < reset( $count ) / $this->dbStep; $i++ ){
                $players = $Db->selectTable( self::SQL_SELECT_PLAYERS , array(
                    'bottom_limit' => $i * $this->dbStep,
                    'top_limit' => $this->dbStep * ( $i + 1 ),
                ));

                $temp = array();
                foreach( $players as $player ){
                    array_key_exists( $player['first_name'], $temp )
                        ?
                            $temp[$player['first_name']] .= ',' . $player['vk_id']
                        :
                            $temp[$player['first_name']] = $player['vk_id'];

                }
                Debug::instance()->dump($temp);
                $RedisModel->push( serialize( $temp ));
            }
            $inserted = $RedisModel->len();
            $runtime = round( $Timer->micro() - $startTime, 3 );
            Debug::instance()->dump( 'runtime: ' . $runtime . ' sec</br>queue: ' . $inserted );
        }
    }