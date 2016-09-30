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
Oracle DB, and SQLite. The framework is currently in the pre-release
development and should not be used in a production applications. To find out
how to use the framework checkout the [manual](/manual). To help with the
development, report issues, or get in touch with the developer, see the github
[repo](https://github.com/not--p/Chameleon).

## Getting Started ##

Note prerequisites:

    Ubuntu 16.04
    git knowledge
    sudo access

### Download ###

Download the installer:

[https://owncloud.lakonacomputers.com/index.php/s/NPH3MreeahR396K](https://owncloud.lakonacomputers.com/index.php/s/NPH3MreeahR396K)

### Installation ###

Run the installer:

    ./chameleon-install.bash

Answer the prompts. They will ask for the project directory. Chameleon
assumes the default Apache2 directory usage, and the project directory will be
created in the /var/www directory -- virtual host configuration files are
stored in /etc/apache2/site-enabled.
");
?>
    </div>
</div>
