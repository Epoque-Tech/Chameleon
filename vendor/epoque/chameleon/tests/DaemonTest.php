<?php
namespace Epoque\ChameleonTesting;
use Epoque\Chameleon\Daemon;


/**
 * Description of DaemonTest
 *
 * @author jason favrod <jason@epoquecorportation.com>
 */

class DaemonTest extends Daemon
{
    public static function printRoutes()
    {
        foreach (parent::$routes as $req => $dest) {
            print "$req: $dest\n";
        }
    }


    public static function testAddRoute($testRoute)
    {
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
