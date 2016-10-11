<h2>Daemon Tests</h2>
<?php use Epoque\ChameleonTesting\DaemonTest; ?>


<section class="col-md-8 col-md-offset-1">
    <h3>Testing addRoute</h3>

    <pre><?php
    print "Routes array before:\n";
    DaemonTest::printRoutes();

    $testRoute = ['/testRoute' => 'test-route.php'];
    print "\nAdding Test Route [" . key($testRoute) . ': ' . current($testRoute) . "]\n\n";

    $result = DaemonTest::testAddRoute($testRoute);

    print "Routes array after:\n";
    DaemonTest::printRoutes();
    ?></pre>

    <b>Result: </b>
    <?php
    if ($result)
        print '<span class="label label-success">Pass</span>'."\n";
    else
        print '<span class="label label-danger">Fail</span>'."\n";
    ?>


    <h3>Testing fetchView</h3>
    
    <?php
    
    foreach (\Epoque\Chameleon\Daemon::dirscan(VIEWS_DIR) as $dirItem) {
        if (preg_match('/.php/', $dirItem)) {
            $x = 'http://' . $_SERVER['SERVER_NAME'];
            $y = str_replace('.php', '', $dirItem);
            $v = $x . '/' . $y;
            $z = file_get_contents($v);

            print "<pre>Testing: $v</pre>".PHP_EOL;

            if (preg_match('<html>', $z) && preg_match('</html>', $z)) {
                print '<b>Result: </b><span class="label label-success">Pass</span><br>'."\n";
            }
            else {
                print '<b>Result: </b><span class="label label-danger">Fail</span><br>'."\n";
            }
            
            print "<br>\n";
        }
    }
    
    foreach(\Epoque\Chameleon\Daemon::$routes as $it => $ting) {
        //print "$it\n";
        
        $v = $x . $it;

        if (trim($it) !== '/DaemonTest') {
            print "<pre>Testing: $v</pre>".PHP_EOL;
            $z = file_get_contents($v);

            if (preg_match('<html>', $z) && preg_match('</html>', $z)) {
                print '<b>Result: </b><span class="label label-success">Pass</span><br>'."\n";
            }
            else {
                print '<b>Result: </b><span class="label label-danger">Fail</span><br>'."\n";
            }

            print "<br>\n";
        }
    }
    ?>
    
</section>
