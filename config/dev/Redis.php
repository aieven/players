<?php
    namespace Players\Config;

    class Redis extends \Players\NoSQL\Redis {
        protected static $databases = array(
            'default' => array(
                'servers' => array(
                    'host' => 'localhost',
                    'port'     => 6379,
                ),
            ),
        );
    }
