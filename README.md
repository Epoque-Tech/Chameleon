# Chameleon Framework
PHP General Web Application Prototyping Framework

@version 0.0.6

## What is Chameleon Framework?

Chameleon is an PHP framework for building Web applications. It runs on [Ubuntu
16.04](//www.ubuntu.com) (GNU/Linux) and uses the [Apache](//httpd.apache.org)
Web server. It is designed to support interactions with [MySQL](//www.mysql.com),
[Oracle](//www.oracle.com/database/index.html), and [SQLite](//www.sqlite.org)
database management systems (DBMS). The framework is currently in pre-release
development and should not be used for a production application. To find out
how to use the framework checkout the [manual](/Manual). To help with the
development, report issues, or get in touch with the developer, see the github
[repo](//github.com/not--p/Chameleon).

## Getting Started ##

### Prerequisites:

    Ubuntu 16.04
    git knowledge
    sudo access

### Documentation:

[Live Documentation](http://chameleon.lakonacomputers.com)


### Installation


#### Download
    
[chameleon-install.bash](https://owncloud.lakonacomputers.com/index.php/s/o0qEsigcjQIzXwU)


#### Run

    if [ ! -x chameleon-install.bash ]; then sudo chmod ug+x chameleon-install.bash; fi
    ./chameleon-install.bash

The script will prompt for the user the information needed to setup the new
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
