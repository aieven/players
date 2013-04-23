<?php
namespace Players\Database;

class Connection implements I\IConnection {

    /**
     * @var Connection
     */
    protected static $Instance;

    protected function __construct(){}

    /**
     * @static
     * @return Connection
     */
    public static function instance(){
        if(!static::$Instance ){
            static::$Instance = new static();
        }
        return static::$Instance;
    }

    protected $databases = array();

    /**
     * @param string $name
     * @return \Players\Database\I\IDatabase
     */
    public function get( $name ){
        if(!isset( $this->databases[$name] )){
            $this->databases[$name] = new \Players\Database\Database( \Players\Config\Database::instance( $name ));
        }
        return $this->databases[$name];
    }
}