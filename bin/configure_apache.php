<?php

function configureApache()
{
    enableApacheModules();
    createVHost();
    restartApache();
}


/**
 * enableApacheModules
 * 
 */

function enableApacheModules()
{
    if (preg_match('/ubuntu/', $_SERVER['OS'])) {
        $_SERVER['OS'] = 'ubuntu';
        exec('a2enmod rewrite');
    }
}


/**
 * createVHost
 * 
 */

function createVHost()
{
    print "\nCreating Apache VirtualHost...\n\n";

    $ip          = ask('for ip');
    $serverAdmin = ask('server admin');
    $docRoot     = ask('doc root');
    $serverName  = ask('server name');
    $vhostTemp   = file_get_contents(VHOST_TEMPLATE);
    $vhostFile   = UBUNTU_VHOST_DIR."$serverName.conf";

    $vhostTemp = str_replace('ip', $ip, $vhostTemp);
    $vhostTemp = str_replace('server_admin', $serverAdmin, $vhostTemp);
    $vhostTemp = str_replace('doc_root', $docRoot, $vhostTemp);
    $vhostTemp = str_replace('server_name', $serverName, $vhostTemp);

    file_put_contents($vhostFile, $vhostTemp);
    exec('apachectl restart');
}


/**
 * restartApache
 *
 * Restarts the Apache server. Prints an error message if it fails.
 */

function restartApache()
{
    $output = null;
    $return = null;

    if (config::$platform === 'freebsd') {
        exec('apachectl reload', $output, $return);
    }
    else {
        exec('apachectl restart', $output, $return);
    }

    if ($return != 0) {
        "Restarting Apache failed.\n";
    }
}

