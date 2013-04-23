<?php
    namespace Players\Config;

    use \Players\Utilities as Utils;

    class Registry extends \Players\System\RegistryConfig {

//        public function Router(){
//            return \Players\System\Router::instance();
//        }
//
//        public function SpecialConfig(){
//            return \Players\config\Special::instance();
//        }
//
//        public function DomainConfig(){
//            return \Players\config\Domain::instance();
//        }

        public function Redis(){
            return \Players\NoSQL\Redis::instance();
        }

        public function DatabaseConnection(){
            return \Players\Database\Connection::instance();
        }

        public function DatabaseSpotConnection(){
            return \Players\Database\SpotConnection::instance();
        }

//        public function Request(){
//            return \Players\IO\Request::instance();
//        }
//
//        public function Response(){
//            return new \Players\IO\Response();
//        }
//
//        public function Session(){
//            return \Players\System\Session::instance( $this->Request(), $this->Response());
//        }

        public function Debug(){
            return Utils\Debug::instance();
        }

        public function Logger(){
            return Utils\Logger::instance( LOGS_DIR . \Players\Autoloader::platfotm());
        }

//        public function Url(){
//            return Utils\UrlBuilder::instance();
//        }

        public function Date(){
            return Utils\Date::instance();
        }

        public function Timer(){
            return Utils\Timer::instance();
        }
//
//        public function I18n(){
//            return Utils\I18n::instance( \Players\System\Registry::instance()->SpecialConfig()->get( 'locale' ));
//        }
//
//        public function Curl(){
//            return Utils\Curl::instance();
//        }
    }
