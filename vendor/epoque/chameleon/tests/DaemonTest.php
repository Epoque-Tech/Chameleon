<?php
namespace Epoque\ChameleonTesting;
use Epoque\Chameleon\Daemon;


/**
 * Description of DaemonTest
 *
 * @author jason favrod <jason@epoquecorportation.com>
 */

class DaemonTest extends Daemon implements Test
{
    private static $tests = [
        'Testing addRoute' => testAddRoute,
        'Testing fetchView' => testFetchView,
        'Testing Route Requests' => testRouteRequests
    ];


    public static function run()
    {
        foreach (self::$tests as $header => $test) {
            print '<section class="col-md-8 col-md-offset-1 testSection">'."\n";
            print "<h3>$header</h3>";
            
            if (self::$test()) {
                print "<p>$header: " . '<span class="label label-success">Pass</span>' . "</p>\n";
            }
            else {
                print "<p>$header: " . '<span class="label label-danger">Fail</span>' . "</p>\n";
            }
            
            print "</section>\n";
        }
        
        return;
    }


    public static function printRoutes()
    {
        foreach (parent::$routes as $req => $dest) {
            print "$req: $dest\n";
        }
    }


    public static function testAddRoute()
    {
        $result = False;
        $testRoute = ['/testRoute' => 'test-route.php'];
        
        print "<pre>";
        print "Routes array before:\n";
        self::printRoutes();

        print "\nAdding Test Route [" . key($testRoute) . ': ' . current($testRoute) . "]\n\n";
        self::addRoute($testRoute);

        print "Routes array after:\n";
        self::printRoutes();
        
        print "</pre>";

        if (self::isRoute($testRoute)) {
            $result = True;
        }

        return $result;
    }


    private static function testFetchView()
    {
        $result = True;
        
        foreach (self::dirscan(VIEWS_DIR) as $dirItem) {
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
                    $result = False;
                    print '<b>Result: </b><span class="label label-danger">Fail</span><br>'."\n";
                }
                
                print "<br>";
            }
        }
        
        return $result;
    }
    

    private static function testRouteRequests()
    {
        $result = True;
        
        foreach(self::$routes as $request => $response) {

            if (trim($request) !== '/DaemonTest') {
                $requestURL = 'http://' . $_SERVER['SERVER_NAME'] . $request;
                
                print "<pre>Testing: $requestURL</pre>".PHP_EOL;
                $renderedHtml = file_get_contents($requestURL);

                if (preg_match('<html>', $renderedHtml) && preg_match('</html>', $renderedHtml)) {
                    print '<b>Result: </b><span class="label label-success">Pass</span><br>'."\n";
                }
                else {
                    $result = False;
                    print '<b>Result: </b><span class="label label-danger">Fail</span><br>'."\n";
                }

                print "<br>\n";
            }
        }
        
        return $result;
    }
}
