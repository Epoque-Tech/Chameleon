<?php
require_once 'config.php';
use Epoque\Chameleon\HtmlHead;
use Epoque\Chameleon\Presenter;


HtmlHead::addGlobalCss(CSS_DIR.'custom.css');

// Docs
$docs = [
    ['Manual' => VIEWS_DIR.'docs/manual.php']
];

// Tests
$tests = [
    [ 'CommonTest'   => VIEWS_DIR.'tests/commonTest.php'  ],
    [ 'HtmlHeadTest' => VIEWS_DIR.'tests/htmlHeadTest.php'],
    [ 'JSTest'       => VIEWS_DIR.'tests/JSTest.php'      ],
    [ 'MySQLDBTest'  => VIEWS_DIR.'tests/MySQLDBTest.php' ]
];


foreach ($docs as $doc) {
    Presenter::addRoute($doc);
}

foreach ($tests as $test) {
    Presenter::addRoute($test);
}

?>

<!-- Dynamic HTML Template -->

<!doctype html>
<?php new HtmlHead()?>
<body>
  <?php require_once PHP_DIR.'template.php'; ?>
</body>
</html>
