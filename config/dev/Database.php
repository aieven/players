<?php
    namespace Players\Config;

    class Database extends \Players\Database\Config {
        protected static $databases = array(
            'main' => array(
                'driver' => 'MySQL',
                'host' => 'localhost',
                'port' => '5432',
                'user' => 'player',
                'password'  => 'jakdJxct8W',
                'dbname' => 'players',
                'charset' => 'UTF8',
            ),
        );
    }
