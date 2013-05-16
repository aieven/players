<?php
    namespace Players\NoSQL;

    use Players\Utilities\Debug;

    class Redis implements I\IRedis {

        const
            PORTS_CONFIG_NAME = 'redises',
            SPOTS_CONFIG_NAME = 'redises_spots'
        ;

        /**
         * @var Redis
         */
        protected static $Instance;
        protected static $spotId;

        protected function __construct( $spotId ){
            static::$spotId = $spotId;
        }

        /**
         * @static
         * @param $spotId
         * @return Redis
         */
        public static function instance( $spotId ){
            if(!static::$Instance ){
                static::$Instance = new static( $spotId );
            }
            return static::$Instance;
        }

        protected static $redises = array();
        protected static $ports = array();
        protected static $spots = array();

        protected $instances = array();



//        /**
//         * @param int $spotId
//         * @return \Predis\Client
//         * @throws \UnexpectedValueException
//         */
        /**
         * @return array
         * @throws \UnexpectedValueException
         */
        public function getParameters(){
            if(!static::$spots ){
                $DynamicConfigFile = \Players\Utilities\DynamicConfigFile::instance();
                static::$ports = $DynamicConfigFile->read( static::PORTS_CONFIG_NAME );
                static::$spots = $DynamicConfigFile->read( static::SPOTS_CONFIG_NAME );
            }

            if(!isset( static::$spots[static::$spotId] ))
                throw new \UnexpectedValueException( 'Spot #'. static::$spotId .' is not defined' );

            $redisId = static::$spots[static::$spotId];
            if(!isset( static::$ports[$redisId] ))
                throw new \UnexpectedValueException( 'Redis instance #'. $redisId .' is not defined' );

            $server = array(
                'port' => static::$ports[$redisId],
            );
            if(!isset( static::$redises[$redisId] )){
                $hosts = file( ROOT . \Players\Config\Constants::REDIS_CONFIGS .'redis_'. $redisId );
                if(!$hosts )
                    throw new \UnexpectedValueException( 'No config for redis instance #'. $redisId );

                foreach( $hosts as $hostStatus ){
                    if( $hostStatus ){
                        list( $host, $status ) = explode( ' ', trim( $hostStatus ), 2 );
                        if( $status === 'master' ){
                            $server['host'] = $host;
                            break;
                        }
                    }
                }
            }
            return $server;
        }

        /**
         * @return bool
         */
        public function check(){
            ini_set( 'error_log', LOGS_DIR . 'php_error.log' );
            $server = $this->getParameters();
            Debug::instance()->dump( $server );
            if(!@fsockopen ( $server['host'], $server['port'], $errno, $errstr, 3 )){
                error_log( $errstr );

                return false;
            }

            return true;
        }

        /**
         * @return \Predis\Client
         */
        public function get(){
            if(!isset( $this->instances[static::$spotId] ))
                $this->instances[static::$spotId] = new \Predis\Client( $this->getParameters() );

            return $this->instances[static::$spotId];
        }
    }