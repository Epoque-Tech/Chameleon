<?php use Epoque\ChameleonTesting\CommonTest;

$tests = [
    ['method' => 'Warning',
    'message' => 'Testing log warning.'],

    ['method' => 'Error',
     'message' => 'Testing log error.']
];

print "<h2>Common Tests</h2>";

foreach ($tests as $test) {
    print '<section class="col-md-8 col-md-offset-1">'."\n";
    print '<h3>Testing Log ' . $test['method'] . ":</h3>\n";
    print "<pre>\n";
    print "Log Before: \n";
    print CommonTest::tailLog(TRUE)."\n";
    $result = CommonTest::testLoging($test);
    print "Log After: \n";
    print CommonTest::tailLog(TRUE)."\n";
    print "</pre>\n";
    
    if ($result) {
        print '<b>Result: </b><span class="label label-success">Pass</span>'."\n";
    }
    else {
        print '<b>Result: </b><span class="label label-danger">Fail</span>'."\n";
    }
    print "</section>\n";
}

