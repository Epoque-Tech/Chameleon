<?php
use cebe\markdown\GithubMarkdown as Parser;

$parser = new Parser(); ?>


<div class="col-md-8 col-md-offset-1">
    <div class="jumbotron">
<?php
print $parser->parse("
## What is Chameleon Framework?

Chameleon is an PHP framework for building Web applications. It requires Ubuntu
Linux and Apache Web server. It also (somewhat) supports interactions with MySQL,
Oracle DB, and SQLite. The framework is currently in the early beta phase of
development and used in a few production applications. To find out how to use
the framework checkout the [manual](/manual). To help with the development,
report issues, or get in touch with the developer, see the github
[repo](https://github.com/not--p/Chameleon).
");
?>
    </div>
</div>
