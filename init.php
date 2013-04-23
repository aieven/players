<?php
require_once ROOT .'const.php';

// Load common exceptions
require_once LIB_DIR .'Exception/Common.php';

// \Players autoload
require_once LIB_DIR .'Autoloader.php';

\Players\Autoloader::register( defined( 'PLATFORM' ) ? PLATFORM : 'dev' );

\Players\System\Registry::instance()->initialize( Players\Config\Registry::instance());

// \PRedis autoload
require_once EXTERNAL_DIR .'predis/autoload.php';

date_default_timezone_set( 'Europe/London' );

// todo temp
error_reporting( ( E_ALL | E_STRICT ) ^ E_WARNING );