<?php
    namespace Players\System;

    abstract class RegistryConfig implements \Players\I\IRegistry {
        /**
         * @var RegistryConfig $Instance
         */
        protected static $Instance;

        final protected function __construct(){}

        /**
         * @static
         * @return RegistryConfig
         */
        final public static function instance(){
            if(!static::$Instance ){
                static::$Instance = new static();
            }
            return static::$Instance;
        }
    }