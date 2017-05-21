#!/bin/bash


debug=2
error=0

www_user="www-data"
www_group="www-data"

www_dir=/var/www
vhost_dir=/etc/apache2/sites-enabled
vhost_template=conf/apacheVirtualHost.txt

sudo=/usr/bin/sudo
aptget=/usr/bin/apt-get
sg=/usr/bin/sg
a2enmod=/usr/sbin/a2enmod
service=/usr/sbin/service
cat=/bin/cat
cp=/bin/cp
git=/usr/bin/git

LAMP_PACKAGES="apache2 mysql-server sqlite3 php7.0 php7.0-cli php7.0-mysql \
php7.0-sqlite3 php7.0-odbc php7.0-json php7.0-mbstring php7.0-xml \
libapache2-mod-php7.0"

chameleon_repo="https://github.com/not--p/Chameleon.git"
required_dirs="log views resources/css resources/js resources/img \
resources/html resources/php resources/sql"
required_files="log/access.log log/chameleon.log"
config_files="index.php config.php RequestHandler.php"

