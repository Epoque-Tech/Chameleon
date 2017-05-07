<?php
require_once 'config.php';
use Epoque\Chameleon\HtmlHead;
use Epoque\Chameleon\Presenter;


HtmlHead::addGlobalCss(CSS_DIR.'custom.css');
?>

<!-- Dynamic HTML Template -->

<!doctype html>
<?php new HtmlHead()?>
<body>
  <?php require_once PHP_DIR.'template.php'; ?>
</body>
</html>
