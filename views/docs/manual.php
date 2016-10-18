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
        <li><a href=\"#setup\">Chameleon Setup</a></li>
    </ol>
    <li><a href=\"#conventions\">Conventions</a></li>
    <li><a href=\"#objects\">Chameleon Objects</a></li>
</ol>


<h2 id=\"gettingStarted\">Getting Started</h2>

The Chameleon framework is used to quickly setup new Web applications. It
currently only supports applications using Apache (2.6) webserver on Ubuntu
16.04.



### <span id=\"install\">Installation</span>

[https://owncloud.lakonacomputers.com/index.php/s/NPH3MreeahR396K](//owncloud.lakonacomputers.com/index.php/s/NPH3MreeahR396K)

### Running the Chameleon script <span id=\"setup\"></span>

    sudo ./chameleon-install.bash
    
## Conventions <span id=\"conventions\"></span>

### Directory Structure

**conf** → contains configuration templates.

**log** → contains the log files.

**resources** → contains `css`, database (`db`), `html`, image (`img`), javascript (`js`), and `php`.

**vendor** → contains composer components.

**views** → contains pages/scripts that are shown to the user.

#### Notes on Directory Structure

-- The chameleon (bin/chameleon) script 

### DIR Constants
All PHP constants defined in Chameleon that represent directories and
are named 'such-and-such' `DIR` (i.e. `CSS_DIR`, `JS_DIR`, etc) end
with a trailing slash.

## Chameleon Script

The chameleon script (located in the root directory of the application)
runs with root permissions.

The usage is as follows:

    setup:         run this command to initialize a chameleon project. 
    index:         restore/create the default index.php file. 
    css:           restore/create the default custom.css file. 
    config-php:    (re)configure project's PHP (config.php) 
    config-js:     (re)configure project's JavaScript (resources/js/config.js) 
    config-apache: (re)configure project's Apache configuration. 
    logs:          (re)create project's log directory and log files.

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
