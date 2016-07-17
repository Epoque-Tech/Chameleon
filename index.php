<?php

require_once 'config.php';
use Epoque\Chameleon\HtmlHead;
use Epoque\Chameleon\Daemon;


HtmlHead::addGlobalCss(CSS_DIR.'custom.css');

// Docs
$docs = [
    ['/manual' => VIEWS_DIR.'docs/manual.php']
];

foreach ($docs as $doc) {
    Daemon::addRoute($doc);
}

// Tests
$tests = [
    ['/DaemonTest' => 'vendor/epoque/chameleon/tests/DaemonTest.php'],
    ['/CommonTest' => 'vendor/epoque/chameleon/tests/CommonTest.php']
];

foreach ($tests as $test) {
    Daemon::addRoute($test);
}

?>

<!doctype html>
<?php new HtmlHead()?>
<body>
    <div class="container">
        <div class="row">
            <h1>Chameleon Web Application Framework</h1>
            <div class="col-md-12">
                <ul class="nav nav-pills">
                  <li role="presentation"><a href="/">Home</a></li>
                  
                  <li role="presentation" class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    Docs <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                      <?php
                      foreach ($docs as $doc) {
                          foreach ($doc as $dkey => $dval)
                            print '<li><a href="'.$dkey.'">'.ltrim($dkey, '/')."</a></li>";
                      }
                      ?>
                    </ul>
                  </li>
                  
                  <li role="presentation" class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    Tests <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                      <?php
                      foreach ($tests as $test) {
                          foreach ($test as $tkey => $tval)
                            print '<li><a href="'.$tkey.'">'.ltrim($tkey, '/')."</a></li>";
                      }
                      ?>
                    </ul>
                  </li>
                  
                </ul>
            </div>
        </div>
        <br>
        
        <div class="row">
            <?php Daemon::fetchRequested(); ?>
        </div>
    </div>
</body>
</html>
