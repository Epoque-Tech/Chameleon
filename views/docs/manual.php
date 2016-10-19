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
    <li><a href=\"#objects\">Chameleon Objects</a></li>
</ol>


<h2 id=\"gettingStarted\">Getting Started</h2>

The Chameleon framework is used to quickly setup new Web applications. It
currently only supports applications using Apache (2.6) webserver on Ubuntu
16.04. Chameleon provides a prototyping (non-performance-optimized) environment.
It uses [git](//git-scm.com) and [composer](//getcomposer.org) and tries to follow
[PHP FIG](//www.php-fig.org) standards.

### <span id=\"install\">Installation</span>

Download the Chameleon installation script:

[https://owncloud.lakonacomputers.com/index.php/s/NPH3MreeahR396K](//owncloud.lakonacomputers.com/index.php/s/NPH3MreeahR396K)

Run the installation script:

    if [ ! -x chameleon-install.bash ]; then sudo chmod ug+x chameleon-install.bash; fi
    ./chameleon-install.bash

The script will prompt for the user the information needed to setup the new
Chameleon project.

## Conventions <span id=\"conventions\"></span>

### Directory Structure

**conf** → contains configuration templates.

**log** → contains the log files.

**resources** → contains CSS, database, HTML, images, JavaScript, and PHP.

**vendor** → contains composer components.

**views** → contains pages/scripts that are shown to the user.

### DIR Constants
All PHP constants defined in Chameleon that represent directories and
are named 'such-and-such' `_DIR` (i.e. `CSS_DIR`, `JS_DIR`, etc) end
with a trailing slash.

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

");
?>
</div>
