<?php
namespace Epoque\ChameleonTesting;
use Epoque\Chameleon\Common;


/**
 * Description of CommonTest
 *
 * @author jason favrod <jason@epoquecorportation.com>
 */

class CommonTest extends Common implements Test
{
    private static $tests = [
        ['method' => 'Warning',
        'message' => 'Testing log warning.'],

        ['method' => 'Error',
         'message' => 'Testing log error.']
    ];


    public static function run()
    {
        foreach (self::$tests as $test) {
            print '<section class="col-md-8 col-md-offset-1 testSection">'."\n";
            print '<h3>Testing Log ' . $test['method'] . ":</h3>\n";
            print "<pre>\n";
            print "Log Before: \n";
            print self::tailLog(TRUE)."\n";
            $result = CommonTest::testLoging($test);
            print "Log After: \n";
            print self::tailLog(TRUE)."\n";
            print "</pre>\n";

            if ($result) {
                print '<b>Result: </b><span class="label label-success">Pass</span>'."\n";
            }
            else {
                print '<b>Result: </b><span class="label label-danger">Fail</span>'."\n";
            }
            print "</section>\n";
        }
    }


    /**
     * tailLog
     * 
     * Returns the result of a tail -5 command on the LOG_FILE as
     * either a array or an string.
     * 
     * @param boolean $string True for a string result, false (default)
     * for an array.
     * @return string The result of a `tail -5` command on the LOG_FILE.
     */

    private static function tailLog($string=false)
    {
        $tailCommand = 'tail -5 ' . LOG_FILE;
        $tailCommandOutput = [];
        $tailOutput = NULL;

        exec($tailCommand, $tailCommandOutput);

        if ($string) {
            foreach ($tailCommandOutput as $line) {
                $tailOutput .= "$line\n";
            }
        }
        else {
            $tailOutput = $tailCommandOutput;
        }

        return $tailOutput;
    }


    /**
     * testLogging
     * 
     * Looks at the tail of the LOG_FILE before sending a test logging
     * message and afterwards to see if the message is successfully
     * logged.
     * 
     * @param assoc_array $spec The sepcification of the test [
     *      'method' => type of logging to test {'warn', 'err'},
     *      'message' => the logging message string
     * ]
     * 
     * @return boolean True if logging was successful, false otherwise.
     */

    private static function testLoging(&$spec)
    {
        $logBefore = self::tailLog();
        $uuid = uniqid();
        
        // Perform Logging
        if ($spec['method'] === 'Warning') {
            parent::logWarning($spec['message'] . " $uuid.");
        }
        else if ($spec['method'] === 'Error') {
            parent::logError($spec['message'] . " $uuid.");
        }

        $logAfter = self::tailLog();
        
        $beforeLastLine = $logBefore[count($logBefore) - 1];
        $afterLastLine = $logAfter[count($logAfter) - 1];
        
        if ($beforeLastLine !== $afterLastLine && preg_match("/$uuid/", $afterLastLine)) {
            return TRUE;
        }
        else {
            return FALSE;
        }
    }
}
