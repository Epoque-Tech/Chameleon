<?php

require_once('vendor/autoload.php');


error_reporting(E_ERROR | E_PARSE | E_WARNING);
#(E_ERROR | E_PARSE | E_WARNING)


// Dates Formatting
define('PUBDATE_FORMAT', 'M d, Y');
date_default_timezone_set('UTC');


// Setup some constants.
define('SITE_TITLE', "|site_title|");

define('APP_ROOT', __DIR__.'/');
define('WEB_ROOT', '/');
define('RESOURCES_DIR', WEB_ROOT.'resources/');
define('CSS_DIR', RESOURCES_DIR.'css/');
define('IMG_DIR', RESOURCES_DIR.'img/');
define('JS_DIR', RESOURCES_DIR.'js/');
define('LOG_DIR', 'log/');
define('LOG_FILE', LOG_DIR.'chameleon.log');
define('VIEWS_DIR', APP_ROOT.'views/');
define('DEFAULT_VIEW', VIEWS_DIR.'homepage.php');
define('ERROR_404_FILE', VIEWS_DIR.'404.php');

define('BOOTSTRAP_VER', '3.3.6');
define('JQUERY_VER', '2.2.0');
define('JQUERYUI_VER', '1.11.4');


// Database Information
define('DB_DRIVER', '|db_driver|');
define('DB_NAME', '|db_name|');
define('DB_USER', '|db_user|');
define('DB_PASS', '|db_pass|');
define('DB_HOST', '|db_host|');
define('DB_FILE', '|db_file|');
define('DB_DSN',  '|db_dsn|');

