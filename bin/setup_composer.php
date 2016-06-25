<?php

/**
 * setupComposer
 * 
 * Sets up default composer installation from COMPOSER_JSON_TEMPLATE.
 * Requires composer to be installed.
 */

function setupComposer()
{
    print "\nSetting up Composer...\n\n";
    
    $composerFile = '';
 
    $user = checkForShellAcct($_SERVER['PROJECT_USER']);

    if (file_exists($_SERVER['PROJECT_DIR'].'composer.phar')) {
        $composerFile = $_SERVER['PROJECT_DIR'].'composer.phar';
    }
    else if (file_exists('composer')) {
        $composerFile = $_SERVER['PROJECT_DIR'].'composer';
    }
    else {
        exit("Composer not installed\n");
    }
    
    if (file_exists($_SERVER['PROJECT_DIR'].'composer.json')) {
        unlink($_SERVER['PROJECT_DIR'].'composer.json');
    }
    if (file_exists($_SERVER['PROJECT_DIR'].'composer.lock')) {
        unlink($_SERVER['PROJECT_DIR'].'composer.lock');
    }
    
    file_put_contents($_SERVER['PROJECT_DIR'].'composer.json',
        file_get_contents($_SERVER['PROJECT_DIR'].COMPOSER_JSON_TEMPLATE));
    
    exec('su '.$user." -c \"$composerFile self-update\"");
    exec('su '.$user." -c \"$composerFile update\"");
}


function checkForShellAcct($acct)
{
    exec('cat /etc/passwd | grep '. $acct, $userInfo);

    if (preg_match('/nologin/', $userInfo[0])) {
        print $_SERVER['PROJECT_USER']." not a shell account\n";

        return
        checkForShellAcct(readline("Please enter a user to setup composer.\n"));
    }
    else {
        return $acct;
    }

}
