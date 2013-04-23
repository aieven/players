<?php
    /**
        Creat database with test data
     */
    namespace Players\Script\Cron\Database;

    use Players\Utilities\Debug;
    use Players\Utilities\Timer;

    class CreateDbScript extends \Players\Script\Base {

        private $rows = 2000000;
        private $step = 100000;
        private $namesCount = 100;

        const SQL_CREATE_TABLE = <<<SQL
    -- SQL_CREATE_TABLE
    CREATE TABLE IF NOT EXISTS {{ t("players") }}(
      vk_id int(11) AUTO_INCREMENT,
      first_name varchar( 200 ) NOT NULL default 'first_name',
      PRIMARY KEY  ( vk_id )
    ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
SQL;

        const SQL_GENERATE_DATA = <<<SQL
    -- SQL_GENERATE_DATA
    INSERT INTO players ( vk_id, first_name ) VALUES
     {{ BEGIN players }}
       {{ UNLESS _first }},{{ END }} ( {{ i(index) }}, {{ s(first_name) }} )
     {{ END players }};
SQL;

        public function run(){
            $Timer = Timer::instance();
            $startTime = $Timer->micro();

            $Db = $this->db( 'main' );
            $Db->query( self::SQL_CREATE_TABLE , array());

            $players = array();
            for( $i = 1, $j = 0; $i <= $this->rows; $i++, $j++ ){
                if( $i % $this->namesCount == 0 )
                    $j = 0;
                $players[] = array( 'index' => $i, 'first_name' => 'first_name_' . $j );

                if( $i % $this->step == 0 || $i == $this->rows ){
                    $Db->query( self::SQL_GENERATE_DATA, array( 'players' => $players ));
                    $players = array();
                }
            }
            $runtime = round( $Timer->micro() - $startTime, 3 );
            Debug::instance()->dump( 'runtime: ' . $runtime . ' sec</br>inserted: ' . ( $i - 1 ));
        }
    }