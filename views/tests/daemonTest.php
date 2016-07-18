<h2>Daemon Tests</h2>
<?php use Epoque\ChameleonTesting\DaemonTest; ?>


<section class="col-md-8 col-md-offset-1">
    <h3>Testing addRoute</h3>

<pre>
<?php
print "Routes array before:\n";
DaemonTest::printRoutes();

$testRoute = ['/testRoute' => 'test-route.php'];
print "\nAdding Test Route [" . key($testRoute) . ': ' . current($testRoute) . "]\n\n";

$result = DaemonTest::testAddRoute($testRoute);

print "Routes array after:\n";
DaemonTest::printRoutes();
?>
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
