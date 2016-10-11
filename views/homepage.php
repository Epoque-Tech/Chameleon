<?php
use cebe\markdown\GithubMarkdown as Parser;

$parser = new Parser(); ?>


<div class="col-md-8 col-md-offset-1">
    <div class="jumbotron">
<?php
print $parser->parse("
## What is Chameleon Framework?

Chameleon is an PHP framework for building Web applications. It runs on [Ubuntu
16.04 (GNU/Linux)](//www.ubuntu.com) and uses the [Apache](//httpd.apache.org)
Web server. It is designed to support interactions with [MySQL](//www.mysql.com),
[Oracle](//www.oracle.com/database/index.html), and [SQLite](//www.sqlite.org)
database management systems (DBMS). The framework is currently in pre-release
development and should not be used for a production application. To find out
how to use the framework checkout the [manual](/manual). To help with the
development, report issues, or get in touch with the developer, see the github
[repo](//github.com/not--p/Chameleon).

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

Answer the prompts. You will be asked for the project directory. Chameleon
assumes usage of the default Apache2 directory (`/var/www`) -- virtual host
configuration files are stored in `/etc/apache2/site-enabled`.
");
?>
    </div>
</div>
