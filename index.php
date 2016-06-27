<?php

require_once 'config.php';
use Epoque\Chameleon\HtmlHead;
use Epoque\Chameleon\Daemon;


HtmlHead::addGlobalCss('//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');
HtmlHead::addGlobalCss(CSS_DIR.'custom.css');
?>

<!doctype html>
<?php new HtmlHead()?>
<body>
    <div class="container">
        <?php Daemon::fetchRequested(); ?>
    </div>
</body>
</html>
