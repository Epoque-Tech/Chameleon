#!/bin/bash
#
# Chameleon
# 
# Copyright (C) 2016 Lakona Computers
# 
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
# 
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# 
# You should have received a copy of the GNU General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.
#
# @author Jason Favrod <jason@lakonacomputers.com>
#

debug=2
error=0

www_user="www-data"
www_group="www-data"

www_dir=/var/www
vhost_dir=/etc/apache2/sites-enabled

project_dir=""
project_ip="*"
project_admin="webmaster@localhost"
project_fqdn=""
project_upstream=""

sudo=/usr/bin/sudo
aptget=/usr/bin/apt-get
sg=/usr/bin/sg
a2enmod=/usr/sbin/a2enmod
service=/usr/sbin/service
cat=/bin/cat
cp=/bin/cp
git=/usr/bin/git

LAMP_PACKAGES="mysql-server php7.0 php7.0-cli php7.0-mysql sqlite3 \
php7.0-json php7.0-odbc php7.0-sqlite3 apache2 libapache2-mod-php7.0";

chameleon_repo="https://github.com/not--p/Chameleon.git"
required_dirs="log views resources/css resources/js resources/img \
resources/html resources/php resources/sql"
required_files="log/access.log log/error.log log/chameleon.log"
config_files="index.php config.php RequestHandler.php"


#
# Chameleon Installer
#
# Use this script to download the latest version of Chameleon and
# setup a new Chameleon project.
#

function main
{
    $sudo -v

    lamp_installed

    if [ $? -gt 0 ]; then
        echo "LAMP installed."
    else
        install_lamp_packages 
        
        if [ $? -gt 0 ]; then
            return $?
        fi
    fi

    $sudo $service apache2 restart

    gather_info
    modify_users
    modify_www_dir
    create_project_dir
    setup_git_repo
    create_required_files

    # If there's a project_upstream, then these files will need to be checkout. #
    if [ ! -z "$project_upstream" ]; then
	$sg $www_group -c "$git checkout RequestHandler.php index.php config.php"
    fi

    create_vhost
    setup_composer
    setup_js
}


#
# lamp_installed
#
# Returns 1, if LAMP_PACKAGES are installed; 0 otherwise.
#

function lamp_installed
{
    local dpkg=/usr/bin/dpkg

    for package in $LAMP_PACKAGES; do
        if [ $debug -gt 0 ]; then
            echo "** Verifing package: $package."
        fi

        $sudo $dpkg -s $package > /dev/null

        if [ $? -eq 1 ]; then
            return 0
        fi
    done

    return 1
}


#
# install_lamp_packages
#

function install_lamp_packages
{
    printf "Installing LAMP_PACKAGES... "

    $sudo $aptget install -q=2 $LAMP_PACKAGES 

    if [ $? -gt 0 ];then
        echo "Installing LAMP_PACKAGES failed."
    else
        echo "Installing LAMP_PACKAGES successful."
    fi
}


#
# gather_info
#
# Sets global variables used to complete the installation
# and setup of the Chameleon project.
#

function gather_info
{
    set_project_fqdn
    set_project_ip
    set_project_dir
    set_project_admin
}


#
# set_www_dir
#

function set_www_dir
{
    local confirm
    local default_www_dir=$www_dir

    echo "Would you like to use the default WWW directory ($www_dir)? [Y|n]"
    read confirm

    if [ "${confirm:0:1}" = "n" ] || [ "${confirm:0:1}" = "N" ]; then
        echo "Please provide the path to the WWW directory:"
        read www_dir

        echo "Confirm WWW directory: $www_dir"
        read confirm

        if [ "${confirm:0:1}" = "n" ] || [ "${confirm:0:1}" = "N" ]; then
            www_dir=$default_www_dir
            set_www_dir
        fi
    fi

}


#
# set_project_fqdn
#

function set_project_fqdn
{
    local confirm

    echo "Please enter the project's fully qualified domain name (FQDN):"
    read project_fqdn

    echo "Confirm project FQDN: $project_fqdn [Y|n]"
    read confirm

    if [ "${confirm:0:1}" = "n" ] || [ "${confirm:0:1}" = "N" ]; then
        project_fqdn=""
        set_project_fqdn
    fi
}


#
# set_project_ip
#

function set_project_ip
{
    local confirm
    local default_ip=$project_ip

    echo "What is the project's ip address?"
    echo "(Leave empty to used default ($default_ip)"
    read project_ip

    if [ -z "$project_ip" ]; then
        project_ip=$default_ip
    fi

    echo "Use $project_ip as project's ip? [Y|n]"
    read confirm

    if [ "${confirm:0:1}" = "n" ] || [ "${confirm:0:1}" = "N" ]; then
        project_ip=$default_ip
        set_project_ip
    fi
}


#
# set_project_dir
#

function set_project_dir
{
    local confirm

    echo "What is the name of your project directory?"
    read project_dir

    project_dir="$www_dir/$project_dir"

    if [ "$project_dir" = $www_dir/ ]; then
        echo "Project directory cannot be blank."
        set_project_dir
        return 0
    fi

    echo "Confirm project directory: $project_dir [Y|n]"
    read confirm

    if [ "${confirm:0:1}" = "n" ] || [ "${confirm:0:1}" = "N" ]; then
        project_dir=""
        set_project_dir
    fi    
}


#
# set_project_admin
#

function set_project_admin
{
    local confirm
    local default_admin=$project_admin

    echo "Please enter the email address of the project's admin:"
    echo "(Leave blank to use the default ($project_admin))"
    read project_admin

    if [ -z "$project_admin" ]; then
        project_admin=$default_admin
    fi

    echo "Confirm project admin: $project_admin [Y|n]"
    read confirm

    if [ "${confirm:0:1}" = "n" ] || [ "${confirm:0:1}" = "N" ]; then
        project_admin=$default_admin
        set_project_admin
    fi
}


#
# modify_users
#
# Adds a list of users to the $www_group.
#

function modify_users
{
    local err=0
    local usermod=/usr/sbin/usermod

    echo "Modifying users... "
    echo "Enter users in www-data group:"
    echo "(comma-separated list (no spaces))"
    read users
    
    
    for user in $users; do
        $sudo $usermod -aG $www_group $user 
        
        if [ $? -gt 0 ]; then
            $err = $err+1

            if [$debug -gt 0 ]; then
                echo "** Failed to add $user to $www_group."
            fi
        fi
    done

    if [ $err -eq 0 ]; then 
        echo "Modifying users successful."
    else
        echo "Modifying users failed."
    fi

    return $err
}


#
# modify_www_dir
#
# Change ownership and mode of the $www_dir.
#

function modify_www_dir
{
    local chown=/bin/chown
    local err=0

    printf "Modifying $www_dir... "

    $sudo $chown $www_user:$www_group $www_dir 

    if [ $? -gt 0 ]; then
        $err=$err+1

        if [ $debug -gt 0 ]; then
            printf "** Failed to change ownership of $www_dir"
            printf " to $www_user:$www_group.\n"
        fi
    fi

    $sudo chmod 775 $www_dir

    if [ $? -gt 0 ]; then
        $err=$err+1

        if [ $debug -gt 0 ]; then
            echo "** Failed to change mode of $www_dir to 775."
        fi
    fi

    $sudo chmod g+s $www_dir

    if [ $? -gt 0 ]; then
        $err=$err+1

        if [ $debug -gt 0 ]; then
            echo "** Failed to setgid bit on: $www_dir."
        fi
    fi

    if [ $err -eq 0 ]; then
        echo "Modifying www_dir successful."
    else
        echo "Modifying www_dir failed."
    fi

    return $err
}


#
# create_project_dir
#

function create_project_dir
{
    if [ -d "$project_dir" ]; then
        echo "Project directory ($project_dir) already exists; removing..."

        $sudo rm -rf $project_dir


        if [ $? -gt 0 ]; then
            echo "Failed to remove existing project directory."
        else
            echo "Removed existing project directory."
        fi
    fi

    $sg $www_group -c "mkdir $project_dir"

    if [ $? -gt 0 ]; then
        echo "Failed to create project directory ($project_dir)."
        exit 1
    fi


    $sudo chmod g+s $project_dir

    if [ $? -gt 0 ]; then
        echo "Failed to setgid bit on: $project_dir."
    fi
}


#
# setup_git_repo
#

function setup_git_repo
{

    echo "Enter the URL of the project_upstream remote:"
    echo "(Leave blank if unknown)"
    read project_upstream

    $sg $www_group -c "$git clone $chameleon_repo $project_dir"
    cd $project_dir

    $sg $www_group -c "$git remote rename origin chameleon_upstream"
    $sg $www_group -c "$git branch contrib -t chameleon_upstream/contrib"

    if [ "$project_upstream" != "" ]; then
        $sg $www_group -c "$git remote add project_upstream $project_upstream"
        $sg $www_group -c "$git fetch project_upstream master"
        $sg $www_group -c "$git branch master --set-upstream-to project_upstream/master"
	$sg $www_group -c "$git reset --hard 1c5c1c46ccd498b59f53855bd66288f73c6e447e"
	$sg $www_group -c "$git pull project_upstream master"
    else
        $sg $www_group -c "$git branch master --unset-upstream"
    fi
}


#
# create_required_files
#
# Creates the directories and files required for a Chameleon Project.
#

function create_required_files
{
    local err=0

    echo "Creating required directories and files..."

    for dir in $required_dirs; do
        if [ $debug -gt 0 ]; then
            echo "** Making directory $project_dir/$dir."
        fi

        mkdir -p $project_dir/$dir

        if [ $? -gt 0 ]; then
            err=$err+1
        fi

    done

    for file in $required_files; do
        if [ $debug -gt 0 ]; then
            echo "** Making  $project_dir/$file."
        fi

        touch $file

        if [ $? -gt 0 ]; then
            echo "Failed to create $file."
        fi
    done

    for file in $config_files; do
        if [ $debug -gt 0 ]; then
            echo "** Putting $file into place."
        fi

        /bin/cp $project_dir/conf/$file $project_dir/$file

        if [ $? -gt 0 ]; then
            err=$err+1
        fi
    done

    if [ $err -gt 0 ]; then
        echo "Creation of required directories and files failed."
    else
        echo "Creation of required directories and files succeeded."
    fi
}


function create_vhost
{
    local vhost_file="${project_dir/$www_dir/$vhost_dir}.conf"

    $sudo $a2enmod rewrite

    $cat $project_dir/conf/apacheVirtualHost.txt > .tmp_vhost_file

    sed -i "s|ip|$project_ip|g" .tmp_vhost_file
    sed -i "s|server_name|$project_fqdn|g" .tmp_vhost_file
    sed -i "s|server_admin|$project_admin|g" .tmp_vhost_file
    sed -i "s|doc_root|$project_dir|g" .tmp_vhost_file

    $sudo mv .tmp_vhost_file $vhost_file

    if [ $? -gt 0 ]; then
        echo "Failed to create_vhost."
        exit 1
    fi

    $sudo $service apache2 restart
}


#
# setup_composer
#

function setup_composer
{
    $cp $project_dir/conf/composer.json $project_dir

    cd $project_dir
    ./composer.phar update
}


#
# setup_js
#

function setup_js
{
    $sg $www_group -c "$cp $project_dir/conf/chameleon.js $project_dir/resources/js/chameleon.js"

    if [ $? -gt 0 ]; then
        echo "Failed to setup_js."
    fi
}


if [ "$1" != "import" ]; then
    main
fi

