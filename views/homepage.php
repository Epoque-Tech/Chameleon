<?php
use cebe\markdown\GithubMarkdown as Parser;

$parser = new Parser(); ?>


<div class="col-md-8 col-md-offset-1">
<?php
print $parser->parse(file_get_contents(APP_ROOT.'README.md'));
?>
</div>
