<?php
use cebe\markdown\GithubMarkdown as Parser;

$parser = new Parser(); ?>


<br>
<br>
<div class="col-md-8 col-md-offset-1">
<?php
print $parser->parse("
## What is Chameleon Framework?


");
?>
</div>
