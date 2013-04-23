<?php
    namespace Players\Script;

    abstract class Base {
        abstract public function run();

        /**
         * @param $name
         * @return \Players\Database\I\IDatabase
         */
        final protected function db( $name ){
            return \Players\System\Registry::instance()->DatabaseConnection()->get( $name );
        }

        /**
         * @param $name
         * @param $spotId
         * @return \Players\Database\I\IDatabase
         */
        final protected function spotDb( $name, $spotId ){
            return \Players\System\Registry::instance()->DatabaseSpotConnection()->get( $name, $spotId );
        }
    }
