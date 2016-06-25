<?php

$_SERVER['OS'] = null;
$_SERVER['PROJECT_USER'] = null;
$_SERVER['PROJECT_DIR'] = null;


define('COMPOSER_JSON_TEMPLATE', 'conf/composer.json');
define('VHOST_TEMPLATE', 'conf/apacheVirtualHost.txt');
define('PHP_CONFIG_TEMPLATE', 'conf/config.php');
define('REQUEST_HANDLER_TEMPLATE', 'conf/RequestHandler.php');
define('JS_CONFIG_TEMPLATE', 'conf/config.js');
define('INDEX_TEMPLATE', 'conf/index.php');
define('PHP_CONFIG_FILE', 'config.php');
define('JS_CONFIG_FILE', 'resources/js/config.js');
define('CUSTOM_CSS_FILE', 'resources/css/custom.css');
define('DEFAULT_REQUEST_HANDLER', 'RequestHandler.php');
define('LOG_DIR', 'log/');
define('RESOURCES_DIR', 'resources/');
define('CSS_DIR', RESOURCES_DIR.'css/');
define('JS_DIR', RESOURCES_DIR.'js/');
define('IMG_DIR', RESOURCES_DIR.'img/');
define('PHP_DIR', RESOURCES_DIR.'php/');
define('VIEWS_DIR', 'views/');
define('UBUNTU_VHOST_DIR', '/etc/apache2/sites-enabled/');

// Comma separated list of log files used in Chameleon.
define('LOG_FILES', 'error.log,access.log,chameleon.log');

// CSV of supported operating systems.
define('OSES', 'debian,ubuntu');

// CSV of Chameleon Directories
define('DIRS', LOG_DIR.','.VIEWS_DIR.','.RESOURCES_DIR.','.CSS_DIR.','.
        JS_DIR.','.IMG_DIR.','.PHP_DIR.',bin/,conf/,vendor/');

// CSV of Chameleon Files Found in the Project Root Directory.
define('FILES', 'composer.json,composer.phar,composer.lock,config.php,'.
    DEFAULT_REQUEST_HANDLER.',index.php,LICENSE');

require 'ask.php';
require 'setup_composer.php';
require 'configure_apache.php';

