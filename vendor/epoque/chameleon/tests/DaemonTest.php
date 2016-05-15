<?php

/**
 * Description of DaemonTest
 *
 * @author jason favrod <jason@epoquecorportation.com>
 */

use Epoque\Chameleon\Daemon;


class DaemonTest
{
    public static function all()
    {
        print 'Testing addRoute... ';
        if (self::testAddRoute()) {
            print 'pass<br>' . PHP_EOL;
        } else {
            print 'fail<br>' . PHP_EOL;
        }
    }


    private static function testAddRoute()
    {
        $testRoute = ['/testRoute' => 'test-route.php'];

        if (!Daemon::isRoute($testRoute)) {
            Daemon::addRoute($testRoute);
        }
        else {
            return false;
        }

        if (Daemon::isRoute($testRoute)) {
            return true;
        }
        else {
            return false;
        }
    }
}

DaemonTest::all();

