<?php
	namespace Players\I;

    /**
     * Dummy, implements by RegistryConfig
     * Defined methods could be call
     */

	interface IRegistry {

//        /**
//         * @abstract
//         * @return IRouter
//         */
//        public function Router();
//
//        /**
//         * @abstract
//         * @return \Players\I\IRequest
//         */
//        public function Request();
//
//        /**
//         * @abstract
//         * @return \Players\I\IResponse
//         */
//        public function Response();
//
//        /**
//         * @abstract
//         * @return ISession
//         */
//        public function Session();

        /**
         * @abstract
         * @return \Players\Utilities\I\IDebug
         */
        public function Debug();

        /**
         * @abstract
         * @return \Players\Utilities\I\ILogger
         */
        public function Logger();

//        /**
//         * @abstract
//         * @return \Players\Utilities\I\IUrlBuilder
//         */
//        public function Url();

        /**
         * @abstract
         * @return \Players\Utilities\I\IDate
         */
        public function Date();

        /**
         * @abstract
         * @return \Players\Utilities\I\ITimer
         */
        public function Timer();
//
//        /**
//         * @abstract
//         * @return \Players\Utilities\I\ISpecialConfig
//         */
//        public function SpecialConfig();
//
//        /**
//         * @abstract
//         * @return \Players\Utilities\I\IDomainConfig
//         */
//        public function DomainConfig();
//
//        /**
//         * @return \Players\Utilities\I\II18n
//         */
//        public function I18n();

        /**
         * @return \Players\NoSQL\Redis
         */
        public function Redis();

        /**
         * @return \Players\Database\I\IConnection
         */
        public function DatabaseConnection();

        /**
         * @return \Players\Database\I\ISpotConnection
         */
        public function DatabaseSpotConnection();

//        /**
//         * @return \Players\Utilities\I\ICurl
//         */
//        public function Curl();
    }
