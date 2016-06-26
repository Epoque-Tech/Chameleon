<?php

require_once 'config.php';
use Epoque\Chameleon\HtmlHead;
use Epoque\Chameleon\Daemon;


HtmlHead::addGlobalCss(CSS_DIR.'custom.css');
?>

<!doctype html>
<?php new HtmlHead()?>
<body>
    <div class="container">
        <?php \Epoque\Chameleon\Daemon::fetchRequested(); ?>
    </div>
</body>
</html>
