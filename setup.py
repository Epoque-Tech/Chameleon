#!/usr/bin/env python
import os
import sys
import platform
import re
import socket
import subprocess
import tempfile


"""
main

Configures a new Chameleon project and performs the setup of its Apache
virtual host and rewrite module.

return 0 : success
return 1 : general fail
return 5 : insufficent priviledges
"""
def main():
    exit_code = 0

    config = {}
    config['platform']       = ''
    config['dist']           = ''
    config['default_config'] = ''
    config['site_title']    = ''
    config['default_view']   = ''
    config['db_info']        = {}


    if (admin_or_root()):
        if (init(config)):
            if (not set_apache_locations(config)):                  exit_code = 1
            if (exit_code == 0 and not setup_repo()):               exit_code = 1
            if (exit_code == 0 and not db_config(config)):          exit_code = 1        
            if (exit_code == 0 and not write_config(config)):       exit_code = 1
            if (exit_code == 0 and not write_index()):              exit_code = 1
            if (exit_code == 0 and not create_vhost(config)):       exit_code = 1
            if (exit_code == 0 and not enable_mod_rewrite(config)): exit_code = 1
            if (exit_code == 0 and not restart_apache(config)):     exit_code = 1
            if (exit_code == 1): print('Setup script failed.')
        else:
            print('Failed to initialize config.')
            exit_code = 1
    else:
        print('Insufficent Priviledges.')
        print('Please run as root or admin user.')
        exit_code = 5
    
    sys.exit(exit_code)


"""
admin_or_root

Checks for adminstrator or root priviledges.

return True  : Sufficent priviledges.
return False : Insufficent priviledges.
"""
def admin_or_root():
    auth = False
    if (os.geteuid() == 0):
        auth = True

    return auth


"""
init

Set some initial values and ask user for ServerName and DEFAUTL_VIEW
for config.

param dict config The configuration in memory.
return Boolean True if sucessful, False otherwise.
"""
def init(config):
    success = True
    user_response = ''

    # User Prompts:
    ask_site_title  = 'Please enter the site title:\n-> '
    ask_default_view = 'Please enter the file name of the DEFAULT_VIEW [default.php]:\n-> '


    try:
        config['platform'] = platform.system().lower()

        if (config['platform'] == 'linux'):
            config['dist'] = platform.linux_distribution()[0].lower()

        user_response = raw_input(ask_site_title)
        while (not valid(user_response, 'name')):
            print(user_response + ' is an invalid site title.')
            print('Please try again.')
            user_response = raw_input(ask_site_title)

        config['site_title'] = user_response;
        user_response = raw_input(ask_default_view)

        while (not valid(user_response, 'name')):
            print(user_response + ' is an invalid file name.')
            print('Please try again.')
            user_response = raw_input(ask_default_view)

        config['default_view'] = user_response;

        config['default_config'] = 'config.php.default'
        config['db_info']        = {'configured':False, 'name':'', 'user':'', 'pass':'', 'host':''}

    except:
        success = False

    return success


"""
valid

Used to validate user responses (strings)
for a given purpose (purpose).

param string
param purpose

return True  :
return False :
"""
def valid(string, purpose):
    response = True

    if (string == ''):
        response = False

    elif (purpose == 'name'):
        NAME_MAX = 255; 
        response = 1<=len(string)<= NAME_MAX and "/" not in string and "\000" not in string and '*' not in string

    elif (purpose == 'ip'):
        try: 
            socket.inet_aton(string)
        except socket.error:
            response = False

    elif (purpose == 'email'):
        if re.match(r"[^@]+@[^@]+\.[^@]+", string) is None:
            response = False

    elif (purpose == 'path'):
        NAME_MAX = 255; 
        response = 1<=len(string)<= NAME_MAX and  "\000" not in string

    return response


"""
set_apache_locations

Finds the needed Apache configuration locations/files, and stores them
in the configuration dict.

param config {} : Necessary configuration data.
return True  : Successfully set Apache locations into config.
return False : Failed to set Apache locations into config.
"""
def set_apache_locations(config):
    response        = True
    tmpfile         = tempfile.TemporaryFile(mode='w')
    apache_version  = subprocess.check_output(['apachectl', '-v'])
    version_pattern = re.compile('Apache/\d.\d')
    
    # Messages
    version_fail    = 'Failed to discover Apache Version.'
    freebsd_fail    = 'Failed to set Apache configuration details for FreeBSD,'
    linux_fail      = freebsd_fail.replace('FreeBSD', 'Linux.')

    try:
        apache_version = version_pattern.findall(apache_version)[0]
        apache_version = apache_version[apache_version.index('/')+1:]
    except:
        print(version_fail)
        apache_version = ''
        response = False

    if (config['platform'] == 'linux'):
        try:
            if (config['dist'] == 'ubuntu' or config['dist'] == 'debian'):
                config['apache_conf'] = os.path.abspath('/etc/apache2/apache2.conf')
                config['vhost_dir']   = os.path.abspath('/etc/apache2/sites-enabled')
        except:
            print(linux_fail)
            response = False
    
    elif (config['platform'] == 'freebsd' and apache_version != ''):
        try:
            config['apache_conf'] = os.path.abspath('/usr/local/etc/apache'+apache_version.replace('.', '')+'/httpd.conf')
            config['vhost_dir'] = os.path.abspath('/usr/local/etc/apache'+apache_version.replace('.', '')+'/Includes')
        except:
            print(freebsd_fail)
            response = False

    return response


"""
setup_repo

Creates a branch called chameleon that is meant to follow the
development of Chameleon so that this project can be easily updated
to the latest version if desired. Removes remote 'origin', and asks
user to specify a new remote.

TODO: the default is Y, but the if statement is counting on having an
indexed string (so a user can not leave the selection blank).
"""
def setup_repo():
    response          = False
    tmpfile           = tempfile.TemporaryFile(mode='w')
    tmpstr            = ''

    try:
        if (subprocess.call(['git', 'status'], stdout=tmpfile, stderr=tmpfile) == 0):

            if (subprocess.call(['git', 'checkout', 'chameleon'], stdout=tmpfile, stderr=tmpfile) != 0):
                subprocess.call(['git', 'remote', 'rename', 'origin', 'upstream'], stderr=tmpfile);
                subprocess.call(['git', 'branch', 'chameleon'], stderr=tmpfile);
            else:
                print('chameleon branch already created, exiting setup_repo.')

            response = True

        else:
            print('You are not in a git repo!')
            print('Please run the setup script inside of the project repo.')
                
    except:
        print('Failed to setup git repo.')
        print('Is git installed?.')

    tmpfile.close()
    return response


"""
db_config

Ask user for MySQL database Setup.
    # Ask user if they want to specify database connection information.
    # If yes ask for db {name, user, password, host} and store them
    # in config['db_info'] dict.
    # If no, nevermind.

return dict : Containing necessary database configuration values.
return dict : Empty, no database is to be configured.
"""
def db_config(config):

    db_info = {}
    tmpstr  = ''

    # Strings for communication with user.
    ask_about_mysql = 'Would you like to enter MySQL database configuration?'
    ask_about_mysql += ' [y|N]\n--> '
    ask_for_db_name = 'Database name------> '
    ask_for_db_user = 'Database username--> '
    ask_for_db_pass = 'Database password--> '
    ask_for_db_host = 'Database hostname--> '
    # Error Messages
    db_name_err = '! The name you entered is in valid !'
    db_user_err = '! The username you entered is in valid !'
    db_pass_err = '! The password you entered is in valid !'
    db_host_err = '! The hostname you entered is in valid !'

    tmpstr = raw_input(ask_about_mysql)
    if (len(tmpstr) > 0 and tmpstr[0].lower() == 'y'):
        db_info['name'] = raw_input(ask_for_db_name)
        while not valid(db_info['name'], 'name'):
            print(db_name_err)
            db_info['name'] = raw_input(ask_for_db_name)

        db_info['user'] = raw_input(ask_for_db_user)
        while not valid(db_info['user'], 'name'):
            print(db_user_err)
            db_info['user'] = raw_input(ask_for_db_user)

        db_info['pass'] = raw_input(ask_for_db_pass)
        while not valid(db_info['pass'], 'name'):
            print(db_pass_err)
            db_info['pass'] = raw_input(ask_for_db_pass)

        db_info['host'] = raw_input(ask_for_db_host)
        while not valid(db_info['host'], 'name'):
            print(db_host_err)
            db_info['host'] = raw_input(ask_for_db_host)

        db_info['configured'] = True
        config['db_info'] = db_info.copy()
    
    return True


"""
write_config

Create a new configuration file from Chameleon's default configuration.

param dict config The config stored in memory.
return Boolean True on success, False otherwise.
"""
def write_config(config):
    tmp_config  = ''
    tmp_file    = file
    new_config  = file
    response    = True

    default_config_path = os.path.abspath('./' + config['default_config']);
    config_path         = os.path.abspath('./config.php');

    # Open default config and read it into a string.
    try:
        tmp_file     = open(default_config_path, 'r')
        tmp_config   = tmp_file.read()

        tmp_config   = tmp_config.replace('|default_view|', config['default_view'])
        tmp_config   = tmp_config.replace('|site_title|', config['site_title'])

        if (config['db_info']['configured']):
            tmp_config   = tmp_config.replace('|db_name|', config['db_info']['name'])
            tmp_config   = tmp_config.replace('|db_user|', config['db_info']['user'])
            tmp_config   = tmp_config.replace('|db_pass|', config['db_info']['pass'])
            tmp_config   = tmp_config.replace('|db_host|', config['db_info']['host'])

        tmp_file.close()

    except:
        print('write_config failed handling tmp_file');
        response = False

    if (response != False):
        try:
            new_config = open(config_path, 'w')
            new_config.write(tmp_config)
            os.chown(config_path, os.stat(default_config_path).st_uid, os.stat(default_config_path).st_gid)
            new_config.close()

        except:
            print('write_config failed writing the tmp_config to new_config')
            response = False

    # Maybe a good place for a loging statement.
    # print('write_config returning ' + str(response))
    return response


"""
set_default_perms
"""
def set_default_perms(file_path):
    default_path  = os.path.abspath('./config.php.default')
    default_perms = {
            'uid': os.stat(default_path).st_uid,
            'gid': os.stat(default_path).st_gid
    }

    os.chown(file_path, default_perms['uid'], default_perms['gid'])


"""
write_index
"""
def write_index():
    index_path         = os.path.abspath('./index.php');
    index_contents     = '<?php\nrequire_once "config.php";\n'
    index              = file
    response           = False

    if (not os.path.isfile('./index.php')):
        try:
            index = open(index_path, 'w')
            index.write(index_contents)
            set_default_perms(index_path)
            index.close()
            response = True
        except:
            print('write_index failed.')
    else:
        print('index.php already exists')
        response = True

    return response


"""
create_vhost

Create an Apache virtual host for the project.
"""
def create_vhost(config):
    vhost       = ''
    ip          = '*'
    server_name = ''
    admin       = 'webmaster@localhost'
    locale      = ''
    vhost_file  = file 
    tmpstr      = ''
    response    = True

    # Strings we need to use for the UI:
    ask_about_ip      = 'Set IP address of Apache Virtual Host? [y|N]\n--> '
    ask_for_ip        = 'What IP would you like to use?\n--> '
    ask_about_admin   = 'Would you like to specify an Apache ServerAdmin? [Y|n]\n--> '
    ask_for_admin     = 'What email would you like to set as ServerAdmin?\n--> '
    ask_for_name      = 'What is the Apache ServerName?\n--> '
    ask_for_locale    = 'What is the DocumentRoot of the project?\n--> '

    ip_validation_err = '! IP address given is not valid !'
    name_error        = '! Name given is not valid !'
    filesystem_error  = '! Not a Valid !'
    vhost_fopen_err   = 'Failed to open virutal host file in '+config['vhost_dir']+'/'+server_name+'.conf.'
    vhost_fwrite_err  = 'Failed to write virutal host file in '+config['vhost_dir']+'/'+server_name+'.conf.'


    try:
        # Ask the things:
        tmpstr = raw_input(ask_about_ip)
        if (len(tmpstr) > 0 and tmpstr[0].lower() == 'y'):
            ip = raw_input(ask_for_ip)
            while not valid(ip, 'ip'):
                print ip_validation_error
                ip = raw_input(ask_for_ip)

        tmpstr = raw_input(ask_about_admin)
        if (len(tmpstr) < 1 or  tmpstr[0].lower() != 'n'):
            admin = raw_input(ask_for_admin)
            while not valid(admin, 'name'):
                print name_error
                admin = raw_input(ask_for_admin)
        
        name = raw_input(ask_for_name)
        while not valid(name, 'name'):
            print name_error
            name = raw_input(ask_for_name)

        locale = raw_input(ask_for_locale)
        while not valid(locale, 'path'):
            print filesystem_error
            name = raw_input(ask_for_name)
    except:
        print(vhost_fwrite_err)
        response = False

    try:
        vhost_file = open(config['vhost_dir']+'/'+server_name+'.conf', 'w')

        # Write the virtual host to memory:
        vhost  = '<VirtualHost '+ip+':80>\n'
        vhost += '\tServerAdmin '+admin+'\n'
        vhost += '\tServerName '+name+'\n'
        vhost += '\tDocumentRoot '+locale+'\n'
        vhost += '\n\t<Directory '+locale+'/>\n'
        vhost += '\tOptions Indexes FollowSymLinks\n'
        vhost += '\tAllowOverride All\n'
        vhost += '\tRequire all granted\n'
        vhost += '\t</Directory>\n'
        vhost += '</VirtualHost>\n'

        # Dump vhost to the vhost file and close vhost file:
        vhost_file.write(vhost)
        vhost_file.close()

    except:
        print(vhost_fopen_err)
        response = False


    return response


"""
enable_mod_rewrite

return True  : mod_rewrite is enabled.
return False : mod_rewrite not enabled.
"""
def enable_mod_rewrite(config):
    response    = True
    tp          = tempfile.TemporaryFile(mode='w')
    httpd_conf  = ''
    rewrite_str = re.compile('LoadModule rewrite_module libexec/apache24/mod_rewrite\.so')

    # Messages
    debian_fail     = 'Failed to enable_mod_rewrite for Debian'
    httpd_read_err  = 'enable_mod_rewrite could not read httpd.conf.'
    httpd_write_err = 'enable_mod_rewrite could not write httpd.conf.'


    if (config['platform'] == 'linux'):

        if (config['dist'] == 'ubuntu' or config['dist'] == 'debian'):
            try:
                response = subprocess.call(['a2enmod', 'rewrite'])
            except:
                print(debian_fail)
                response = False

    if (config['platform'] == 'freebsd'):
        try:
            tf         = open(config['apache_conf'], 'r+')
            httpd_conf = tf.read()
            tf.close()
        except:
            print(httpd_read_err)
            response = False
        
        if (len(rewrite_str.findall(httpd_conf)) == 0):
            try:
                tf = open(config['apache_conf'], 'w')
                tf.write(httpd_conf + '\nLoadModule rewrite_module libexec/apache24/mod_rewrite.so')
                tf.close()
            except:
                print(httpd_write_err)
                response = False

    return response


"""
restart_apache

Issues the approprate command to restart Apache.
"""
def restart_apache(config):
    response = True
    tf       = file

    if (config['platform'] == 'linux'):

        if (config['dist'] == 'ubuntu'):
            if (subprocess.call(['apachectl', 'restart']) != 0):
                response = False

    if (config['platform'] == 'freebsd'):
        if (subprocess.call(['apachectl', 'reload']) != 0):
            response = False

    return response



if __name__ == '__main__':
    main()

