<?php
require_once 'config.php';
use Epoque\Chameleon\HtmlHead;
use Epoque\Chameleon\Presenter;
use Epoque\Chameleon\JS;


HtmlHead::addGlobalCss(CSS_DIR.'custom.css');
Presenter::addRoute(['test/*' => 'test.php']);
JS::addRoute(['test/*' => 'test.js']);
?>

<!-- Dynamic HTML Template -->

<!doctype html>
<?php new HtmlHead()?>
<body>
    <div class="container">

        <div id="nav-row" class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills">
                  <li role="presentation"><a href="/">Home</a></li>

                  <li role="presentation" class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    Docs <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                    </ul>
                  </li>

                  <li role="presentation" class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    Tests <span class="caret"></span>
                    </a>
                    <ul id="test-dropdown" class="dropdown-menu">
                        <li role="resentation"><a href="/test/HtmlHead">HtmlHead</a></li>
                    </ul>
                  </li>

                </ul>
            </div>
        </div>
        <br>

        <div id="presentation-row" class="row">
            <?php Epoque\Chameleon\Presenter::fetchRoute(); ?>
        </div>

    </div>

    <?php Epoque\Chameleon\JS::trio(); ?>
    <?php Epoque\Chameleon\JS::fetchRoute(); ?>

</body>
</html>
