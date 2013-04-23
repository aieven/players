<?php
    namespace Players\Database\Helper;

    class BlitzTemplator implements \Players\Database\I\ISQLTemplator {

        /**
         * @var \Players\Database\I\IConfig
         */
        private $Config;

        /**
         * @param \Players\Database\I\IConfig $Config
         */
        public function __construct( \Players\Database\I\IConfig $Config ){
            $this->Config = $Config;
        }

        /**
         * @param string $tpl
         * @param array $args
         * @param mixed $spotId
         * @return string
         */
        public function parseSQL( $tpl, $args, $spotId = null ){
            if( empty( $args ) && false === strpos( $tpl, '{' ))
                return $tpl;

            $T = new Blitz( $this->Config, $spotId );
            $T->load( $tpl );
            $T->set( $args );

            return $T->parse();
        }
    }
