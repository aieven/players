<?php
    namespace Players\Model\I;

    interface IQueue {
        /**
         * @abstract
         * @param $data
         * @return bool
         */
        public function push( $data );

        /**
         * @abstract
         * @param int $count
         * @return bool|array
         */
        public function pull( $count = 1 );

        /**
         * @abstract
         * @return int
         */
        public function len();
    }
