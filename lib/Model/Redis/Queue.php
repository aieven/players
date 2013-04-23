<?php
namespace Players\Model\Redis;

use Players\Utilities\Debug;

class Queue extends Base implements \Players\Model\I\IQueue {

    public function __construct( $name, $spotId = 1 ){
        parent::__construct( $name, $spotId );

        $this->name = $spotId. '_queue_'. $name;
    }

    public function push( $data ){
        try {
            $args = func_get_args();
            array_unshift( $args, $this->name );
            call_user_func_array( array( $this->client(), 'rpush' ), $args );
            return true;
        }
        catch( \Exception $E ){
            \Players\System\Registry::instance()->Logger()->logException( $E );
            return false;
        }
    }

    public function pull( $count = 1 ){
        try {
            $load = array();
            while( $count-- ){
                $val = $this->client()->lpop( $this->name );
                if(!$val )
                    break;
                $load[] = $val;
            }
            return $load;
        }
        catch( \Exception $E ){
            \Players\System\Registry::instance()->Logger()->logException( $E );
            return false;
        }
    }

    public function len(){
        try {
            return $this->client()->llen( $this->name );
        }
        catch( \Exception $E ){
            \Players\System\Registry::instance()->Logger()->logException( $E );
            return false;
        }
    }
}
