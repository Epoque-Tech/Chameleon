<?php

require_once 'config.php';
use Epoque\Chameleon\HtmlHead;
use Epoque\Chameleon\Daemon;


HtmlHead::addGlobalCss(CSS_DIR.'custom.css');
Daemon::addRoute(['/daemon-test' => 'vendor/epoque/chameleon/tests/DaemonTest.php']);
?>

<!doctype html>
<?php new HtmlHead()?>
<body>
<?php Daemon::fetchRequested(); ?>
</body>
</html>
