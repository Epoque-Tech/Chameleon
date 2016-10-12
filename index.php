<?php

require_once 'config.php';
use Epoque\Chameleon\HtmlHead;
use Epoque\Chameleon\Daemon;


HtmlHead::addGlobalCss(CSS_DIR.'custom.css');

// Docs
$docs = [
    ['/Manual' => VIEWS_DIR.'docs/manual.php']
];

foreach ($docs as $doc) {
    Daemon::addRoute($doc);
}

// Tests
$tests = [
    ['/CommonTest' => VIEWS_DIR.'tests/commonTest.php'],
    ['/DaemonTest' => VIEWS_DIR.'tests/daemonTest.php'],
    ['/HtmlHeadTest' => VIEWS_DIR.'tests/htmlHeadTest.php']
];

foreach ($tests as $test) {
    Daemon::addRoute($test);
}

?>

<!-- Dynamic HTML Template -->

<!doctype html>
<?php new HtmlHead()?>
<body>
  <?php require_once PHP_DIR.'template.php'; ?>
</body>
</html>
