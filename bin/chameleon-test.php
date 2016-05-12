#!/usr/bin/php5
<?php

namespace test;

require('chameleon');

function main(&$argc, &$argv)
{
    if ($argc === 1) {
        testInit();
        testCreateLogs();
        testCreateDirs();
        testCreateIndex();
    }
}


/**
 * testInit
 * 
 * Runs the inti function and tests $_SERVER
 * OS and PROJECT_USER variables for valid values.
 */

function testInit()
{
    print 'Testing init...  ';
    init();

    if (in_array($_SERVER['OS'], explode(',', OSES)) &&
        is_string($_SERVER['PROJECT_USER'])) {
        print "pass\n";
    }
    else {
        print "fail\n";
    }
}


/**
 * testCreateLogs
 * 
 * Deletes all log files and log dirs, then runs createLogs.
 * 
 * @return Boolean True if necessary log files and dir is
 * created; false otherwise.
 */

function testCreateLogs()
{

    print 'Testing createLogs...  ';
    $r = "pass\n";

    foreach (explode(',', LOG_FILES) as $log) {
        if (is_file(LOG_DIR."$log")) {
            unlink(LOG_DIR."$log");
        }
    }

    if (is_dir(rtrim(LOG_DIR, '/'))) {
        rmdir(rtrim(LOG_DIR, '/'));
    }
    
    createLogs();

    foreach (explode(',', LOG_FILES) as $log) {
        if (!is_file(LOG_DIR."$log")) {
            $r = "fail\n";
        }
    }

    if (!is_dir(rtrim(LOG_DIR, '/'))) {
        $r = "fail\n";
    }

    print $r;
}


function testCreateDirs()
{
    print 'Testing createDirs... ';
    $r = "pass\n";

    createDirs();


    foreach (explode(',', DIRS) as $dir) {
        if (!is_dir(rtrim($dir, '/'))) {
            $r = "fail\n";
            break;
        }
    }

    print $r;
}


function testCreateIndex()
{
    if (is_file()) {
    
    }
}


// Run if executing from command line.
if (php_sapi_name() === "cli") {
    \test\main(count($argv), $argv);
}

