<?php
use Epoque\Chameleon\Router;
use Epoque\Chameleon\Route;


print '
<style>
#routerTestTable {
width: 400px;
}
#routerTestTable td {
border: 1px solid black;
}

</style>
    ';


// Test addRoute. //
print '<p>Try to add the following route:</p>
<pre>
';
$homeRoute = new Route(['home' => VIEWS_DIR.'default.php']);
print $homeRoute;
Router::addRoute($homeRoute);
print Router::toHtml();
print '</pre>';



// Test addRoute with array of Routes, some with empty parts. //
$routeArray = [
    new Route(['' => '']),
    new Route(['/path/no/file' => '']),
    new Route(['' => 'path.no']),
    new Route(['/example/path' => 'example.file'])
];

foreach ($routeArray as $route) {
    print '<p>Add Route:</p>';
    print '<pre>';
    print $route;
    print Router::toHtml();
    print '</pre>';
    Router::addRoute($route);
}



// Test addRoute on IGNORE_EXT. //
print '<p>Define IGNORE_EXT and then add an ingored file to a route:</p>';
define('IGNORE_EXT', 'swp ini');
print 'IGNORE_EXT: ' . IGNORE_EXT;

$ignoreExtRoute = new Route(['file.ini' => VIEWS_DIR.'file.ini']);

$fn = VIEWS_DIR.'file.ini';
$tf = fopen($fn, 'w');

print "<pre>
fopen($fn, 'w');\n".
"$ignoreExtRoute";

Router::addRoute($ignoreExtRoute);

print Router::toHtml()."
fclose($tf);
unlink($fn);
</pre>";
fclose($tf);
unlink($fn);


// Test addRoute on IGNORE_FILES. //
//print '<p>Try adding the ignored route:</p>';

