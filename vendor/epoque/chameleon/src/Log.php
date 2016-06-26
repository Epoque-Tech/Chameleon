<?php

namespace Epoque\Chameleon;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;


/**
 * Description of WarningLog
 *
 * @author jason favrod <jason@lakonacomputers.com>
 */

class Log
{
    private static $logfile;
    private static $log;




    public static function setup($logfile) {
        self::$logfile = $logfile;
        self::$log     = new Logger('chameleon.log');
    }


    /**
     * logWarning
     * 
     * Takes a message and 
     * 
     */
    
    public static function logWarning($message) {
        
    }
}
