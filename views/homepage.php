<?php
use cebe\markdown\GithubMarkdown as Parser;

$parser = new Parser(); ?>


<br>
<br>
<div class="col-md-6 col-md-offset-2">
<?php
print $parser->parse("
# Chameleon Framework Documentation

## Git Repo

    https://github.com/not--p/Chameleon

## Conventions

### DIR Constants
All PHP constants defined in Chameleon that represent directories and
are named 'such-and-such' `DIR` (i.e. `CSS_DIR`, `JS_DIR`, etc) end
with a trailing slash.

## Directory Structure

**conf** → contains configuration templates.

**log** → contains the log files.

**resources** → contains `css`, database (`db`), `html`, image (`img`), javascript (`js`), and `php`.

**vendor** → contains composer components.

**views** → contains pages/scripts that are shown to the user.

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
