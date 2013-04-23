<?php
    namespace Players\Database\Driver;
    
    use \Players\Exception\Database as E;
    use Players\Utilities\Debug;

    class MySQL {
    
        /**
         * @var \Players\Database\I\IConfig
         */
        private $Config;
    
        /**
         * @var resource
         */
        private
            $connection,
            $lastQuery;
    
        /**
         * @param \Players\Database\I\IConfig $Config
         */
        public function __construct( \Players\Database\I\IConfig $Config ){
            $this->Config = $Config;
        }
    
        public function __destruct(){
            if( $this->connection )
                mysql_close( $this->connection );
        }
    
        private function connect(){
            if( $this->connection )
                return $this->connection;
            try {
                $this->connection = mysql_connect(
                    $this->Config->get( 'host' ),
                    $this->Config->get( 'user' ),
                    $this->Config->get( 'password' ),
                    true
                );
                if( $this->connection ){
                    if(!mysql_select_db( $this->Config->get( 'dbname' ), $this->connection )){
                        mysql_close( $this->connection );
                        throw new E\Connection( 'Cannot select database '. $this->Config->get( 'dbname' ));
                    }
                }else
                    throw new E\Connection( 'Cannot connect to database host '. $this->Config->get( 'host' ));
    
                mysql_query( 'SET NAMES "'. $this->Config->get( 'charset' ) .'"', $this->connection );
            }
            catch( \Exception $E ){
                $this->connection = null;
                throw $E;
            }
            return $this->connection;
        }
    
        /**
         * @param $sql
         * @throws \Players\Exception\Database\SQLQuery
         */
        public function query( $sql ){
            \Players\System\Registry::instance()->Logger()->log( 'sql', $sql );
//            Debug::instance()->dump( $sql );
            $this->lastQuery = mysql_query( $sql, $this->connect());
            if(!$this->lastQuery )
                throw new E\SQLQuery( mysql_error( $this->connect()));
        }
    
        /**
         * @return bool|int
         */
        public function getInsertId(){
            return mysql_insert_id( $this->connect());
        }
    
        /**
         * @return int
         */
        public function getAffected(){
            return mysql_affected_rows( $this->connect());
        }
    
        /**
         * @param bool $assoc
         * @return array
         * @throws \Players\Exception\Database\QueryLogicError
         */
        public function fetchRow( $assoc = false ){
            if(!$this->lastQuery )
                throw new E\QueryLogicError( 'Must execute query before fetch row' );
            if( $assoc )
                return mysql_fetch_assoc( $this->lastQuery );
            else
                return mysql_fetch_row( $this->lastQuery );
        }
    
        /**
         * @param string $value
         * @return string
         */
        public function escapeString( $value ){
            return mysql_real_escape_string( strval( $value ));
        }
    

        /**
         * @return bool
         */
        public function close(){
            if( $this->connection ){
                mysql_close( $this->connection );
                $this->connection = null;
            }
            return true;
        }
    }
        