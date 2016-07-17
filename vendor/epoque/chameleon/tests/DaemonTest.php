<?php
namespace Epoque\Chameleon;


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
?>

<div class="col-md-8 col-md-offset-1">
    <h2>Daemon Tests</h2>
    
    <section>
        <h3>Testing addRoute</h3>
        
<?php $testRoute = ['/testRoute' => 'test-route.php']; ?>
<pre>
Routes array before:
<?php DaemonTest::printRoutes(); ?>

Add Test Route
<?php print key($testRoute).': '.current($testRoute)."\n"; ?>
<?php $result = DaemonTest::testAddRoute($testRoute); ?>

Routes array after:
<?php DaemonTest::printRoutes(); ?>
</pre>

        <b>Result: </b>
        <?php
        if ($result) {
            print '<span class="label label-success">Pass</span>'."\n";
        }
        else {
            print '<span class="label label-danger">Fail</span>'."\n";
        }
        ?>

    </section>
</div>
