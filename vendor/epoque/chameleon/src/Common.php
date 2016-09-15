<?php
namespace Epoque\Chameleon;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;


/**
 * A class that all Chameleon classes can extend.
 *
 * @author jason favrod <jason@epoquecorportation.com>
 */

abstract class Common
{
    protected static $log = NULL;


    public static function URI() {
        return filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL);
    }


    private static function initLog()
    {
        if (self::$log === NULL) {
            self::$log = new Logger('chameleon.log');
            self::$log->pushHandler(new StreamHandler(LOG_FILE, Logger::WARNING));
        }
    }


    public static function logWarning($message='')
    {
        self::initLog();
        self::$log->warn($message);
    }


    public static function logError($message='')
    {
        self::initLog();
        self::$log->err($message);
    }
}
