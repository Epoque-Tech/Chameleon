# Chameleon Framework
PHP General Web Application Prototyping Framework

@version 0.1.0

## What is Chameleon Framework?

Chameleon is an PHP framework for building Web applications. It runs on [Ubuntu
16.04](//www.ubuntu.com) (GNU/Linux) and uses the [Apache](//httpd.apache.org)
Web server. The framework is currently in pre-release development and should
not be used for a production application. To find out how to use the framework
checkout the [manual](/Manual). To help with the development, report issues,
or get in touch with the developer, see the github
[repo](//github.com/not--p/Chameleon).

## Getting Started ##

### Prerequisites:

    Ubuntu 16.04
    Apache2.4
    git knowledge

Chameleon assumes Ubuntu 16.04 and Apache2 defaults, therefore system users
that use Apache2 should be in the `www-data` group. If they are not,
[add them to the group](http://www.howtogeek.com/50787/add-a-user-to-a-group-or-second-group-on-linux/).


### Documentation:

Live documentation coming soon.


### Installation

Clone this repository as your project's DocumentRoot (Web root). 

    git clone https://github.com/not--p/Chameleon.git [project DocumentRoot]

Navigate to the project directory and run the setup script.

    chameleon setup

At this point Chameleon is ready to use. Put your markup in the **views**
directory, and your JavaScript - view controllers, if you like - in
**resources/js** (if you give the JavaScript file the same name as the view
file, it will automatically be loaded with the view). There is no yet a
recommended way of handling requests or working with a Model/Database, but the
framework is built loosely enough that you can do that however you like.

The manual will show programmers how to provide unique titles and meta-tags (
description and keywords) for view, as well as how to reference images and load
JavaScript per view.
