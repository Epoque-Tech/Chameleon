#!/usr/bin/env php
<?php

/**
 * createVhost
 *
 * A script to create an Apache VirtualHost for a Chameleon Framework
 * instance based on a template and user input.
 *
 * @author Jason Favrod <jason@epoquecorporation.com>
 */


function start($args)
{
    $run           = True;
    $vhostTemplate = '';
    $templateInput = [
        'ServerName' => '',
        'ServerAdmin' => '',
        'DocumentRoot' => ''
    ];

    
    if (count($args) === 2) {
        print "Creating Apache VirtualHost...\n\n";
        $run = handleArgs($args, $vhostTemplate);

        if ($run) {
            $run = getTemplateInput($templateInput);
        }

        writeVirtualHost($vhostTemplate, $templateInput);

        exec('a2ensite ' . $templateInput['ServerName']);
        exec('service apache2 restart');
    }
    else {
        usage();
    }
}


function usage()
{
    $out  = "createVhost Creates an Apache VirtualHost for Chameleon Framework\n";
    $out .= "usage: createVhost [path/to/vhost_template]\n";

    print $out;
}


function handleArgs(&$args, &$vhostTemplate)
{
    $result = False;

    if (count($args) !== 2) {
        usage();
    }
    else {
        if (is_file($args[1])) {
            $vhostTemplate = $args[1];
            $result = True;
        }
    }

    return $result;
}


function getTemplateInput(&$templateInput)
{
    $run = True;


    while ($run)
    {
        print "Please provide the values for the Apache direcives:\n";

        foreach ($templateInput as $directive => $value) {
            $templateInput[$directive] = trim(readline("$directive: "));
        }

        print "\nAre the following values correct?\n";

        foreach ($templateInput as $directive => $value) {
            print $directive . " = $value\n";
        }

        print "\n";
        $input = readline('Yes or No [default yes]? ');

        if (count($input) !== 0 || strtolower($input)[0] !== 'n') {
            $run = False;
        }
    }

    print "\n";
    return True;
}


function writeVirtualHost(&$vhostTemplate, &$templateInput)
{
    $vhostFile = file_get_contents($vhostTemplate);

    foreach ($templateInput as $directive => $value) {
        // Must replace the lower cased directive with the value.
        $vhostFile = str_replace(strtolower($directive), $value, $vhostFile);
    }
    
    $vhost = '/etc/apache2/sites-available/' . $templateInput['ServerName'] . '.conf';
    file_put_contents($vhost, $vhostFile);
}


start($argv);

