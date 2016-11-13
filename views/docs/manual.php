<?php
use cebe\markdown\GithubMarkdown as Parser;
$parser = new Parser();
?>


<div class="col-md-8 col-md-offset-1">
<?php
print $parser->parse("
# Chameleon Framework Manual

## Table of Contents

<ol type=\"I\">
    <li><a href=\"#gettingStarted\">Getting Started</a></li>
    <ol type=\"i\">
        <li><a href=\"#install\">Installation</a></li>
    </ol>
    <li><a href=\"#conventions\">Conventions</a></li>
<<<<<<< HEAD
    <li><a href=\"#objects\">Chameleon Objects</a></li>
=======
    <ol type=\"i\">
        <li><a href=\"#dirStruct\">Directory Structure</a></li>
        <li><a href=\"#dirConst\">Directory Constants</a></li>
    </ol>
    <li><a href=\"#config\">Configuration</a></li>
    <li><a href=\"#objects\">Chameleon Objects</a></li>
    <ol type=\"i\">
        <li><a href=\"#presenter\">Presenter</a></li>
        <li><a href=\"#js\">JS</a></li>
    </ol>
    <li><a href=\"#jsNajax\">JavaScript and AJAX</a></li>
>>>>>>> live2
</ol>


<h2 id=\"gettingStarted\">Getting Started</h2>

The Chameleon framework is used to quickly setup new Web applications. It
currently only supports applications using Apache (2.6) webserver on Ubuntu
16.04. Chameleon provides a prototyping (non-performance-optimized) environment.
It uses [git](//git-scm.com) and [composer](//getcomposer.org) and tries to follow
[PHP FIG](//www.php-fig.org) standards.

<<<<<<< HEAD
### <span id=\"install\">Installation</span>
=======

<span id=\"install\"></span>
### Installation
>>>>>>> live2

Download the Chameleon installation script:

[https://owncloud.lakonacomputers.com/index.php/s/NPH3MreeahR396K](//owncloud.lakonacomputers.com/index.php/s/NPH3MreeahR396K)

Run the installation script:

    if [ ! -x chameleon-install.bash ]; then sudo chmod ug+x chameleon-install.bash; fi
    ./chameleon-install.bash

The script will prompt for the user the information needed to setup the new
<<<<<<< HEAD
Chameleon project.

## Conventions <span id=\"conventions\"></span>

### Directory Structure

=======
Chameleon project:

    LAMP installed.
    Please enter the project's fully qualified domain name (FQDN):

Enter a fully qualified domain name for the application; this will be used as
the Apache2 ServerName.

    What is the project's ip address?
    (Leave empty to used default (*)

Enter in the ip address used to establish a connection to the application. This
will be defaulted to the FQDN and when running the installer -- unless you have
reason otherwise -- you should enter the FQDN here.

    What is the name of your project directory?

Enter the name of the directory/folder where you want your chameleon instance
installed (chameleon projects are installed in the `/var/www` directory).

    Please enter the email address of the project's admin:
    (Leave blank to use the default (webmaster@localhost))

Enter the email address where you want Apache2 to direct administration emails.
This sets the Apache2 ServerAdmin virtual host directive.

    Modifying users... 
    Enter users in www-data group:
    (comma-separated list (no spaces))

Chameleon assumes Ubuntu 16.04 and Apache2 defaults, therefore system users that
use Apache2 should be in the `www-data` group. If they are not,
[add them to the group](http://www.howtogeek.com/50787/add-a-user-to-a-group-or-second-group-on-linux/).
Here the ownership and permissions are set on the project directory so that
users in the `www-data` group and the Apache2 webserver itself can read and
write the contents of the directory -- access restrictions handled in the Apache2
virtual host configuration file.

    Enter the URL of the project_upstream remote:
    (Leave blank if unknown)
    
If you have a git remote repositiory already initialized for your project, enter
in the repository address here; it will be named `project_upstream`. The remote
that tracks chameleon is called `chameleon_upstream`.

Now the Chameleon repository is cloned, necessary Apache2 modules enabled,
composer run, and necessary files and directories created.


<span id=\"conventions\"></span>
## Conventions

<span id=\"dirStruct\"></span>
### Directory Structure

**bin** → contains executable scripts.

>>>>>>> live2
**conf** → contains configuration templates.

**log** → contains the log files.

<<<<<<< HEAD
**resources** → contains CSS, database, HTML, images, JavaScript, and PHP.
=======
**resources** → contains resources, including but not limited to CSS, database,
HTML, images, JavaScript, and PHP.
>>>>>>> live2

**vendor** → contains composer components.

**views** → contains pages/scripts that are shown to the user.

<<<<<<< HEAD
### DIR Constants
=======

<span id=\"dirConst\"></span>
### DIR Constants

>>>>>>> live2
All PHP constants defined in Chameleon that represent directories and
are named 'such-and-such' `_DIR` (i.e. `CSS_DIR`, `JS_DIR`, etc) end
with a trailing slash.

<<<<<<< HEAD
## config.js

The JavaScrip for Chameleon is configured in the **config.js** file.
The template for this file is found in the conf directory and the live
configuration file is located in **resources/js/config.js** with the
rest of the project's JavaScript files.

The configuration file defines the project's **APP** object (`{}`). The
APP object is global and can be extended. Simply add data and methods
to APP (e.g. `APP.name='chameleon'`).

### JavaScript APP Object

#### Data Members

    requestURL: Stores the url where requests are directed.
    
#### Functional Members


## Request Handling

By default requests are handled by `RequestHandler.php` located in the APP_ROOT.
RequestHandler is created from a template file in the `conf` directory. Simply
add methods to this class for each GET or POST request you want to handle.
=======

<span id=\"config\"></span>
## Configuration

config.php


<span id=\"objects\"></span>
## Chameleon Objects


<span id=\"presenter\"></span>
### Presenter Class

<span id=\"js\"></span>
### JS Class


<span id=\"jsNajax\"></span>
## JavaScript and AJAX

### chameleon.js

### Request Handling

>>>>>>> live2

");
?>
</div>
