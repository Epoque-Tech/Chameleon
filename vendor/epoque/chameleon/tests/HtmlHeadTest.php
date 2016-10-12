<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Epoque\ChameleonTesting;
use Epoque\Chameleon\HtmlHead;


/**
 * Description of HtmlHeadTest
 *
 * @author jason favrod <jason@epoquecorportation.com>
 */
class HtmlHeadTest
{
    private static $htmlHead = null;
    
    private static $tests = [
            'Empty HtmlHead' => emptyTest,
            'Print HtmlHead' => printHtmlHead
    ];


    public static function run()
    {
        self::$htmlHead = trim(new HtmlHead(TRUE));
      
        foreach (self::$tests as $header => $test) {
            print '<section class="col-md-8 col-md-offset-1">' . "\n";
            print "<h3>$header</h3>\n";
            self::$test();
            print '</section>' . "\n";
        }
    }


    private static function headToArray()
    {
        self::$htmlHead = trim(new HtmlHead(TRUE));
        return explode("\n", self::$htmlHead);
    }


    
    private static function emptyTest()
    {
        $r = 0;
        
        $expected = [
            '<head>',
            '<meta charset="utf-8">',
            '<meta http-equiv="X-UA-Compatible" content="IE=edge">',
            '<meta name="viewport" content="width=device-width, initial-scale=1">',
            '<meta name="description" content="">',
            '<meta name="keywords" content="">',
            '<meta name="author" content="">',
            '<link rel="alternate" href="http://camdev.lakonacomputers.com/HtmlHeadTest" hreflang="en-us" /> ',
            '<title>' . SITE_TITLE . '</title>',
            '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">',
            '<link href="/resources/css/custom.css" rel="stylesheet">',
            '</head>'
        ];
        
        print "<pre>\n";
        
        foreach (self::headToArray() as $i => $actual) {
            if ($expected[$i] !== $actual) {
                print "emptyTest error: \n";
                print '    expected: ' . htmlentities($expected[$i]) . "\n";
                print '    actual: ' . htmlentities($actual) . "\n";
                $r++;
            }
        }
        
        $r != 0 ? : print "OK!\n";
        
        print "</pre>\n";
        
        if ($r != 0) {
            print '<span class="label label-danger">Fail</span>' . "\n";
        }
        else {
            print '<span class="label label-success">Pass</span>' . "\n";
        }
    }

    
    private static function printHtmlHead()
    {
        $z = 0;
        $z = print '<pre>' . htmlentities(self::$htmlHead) . '</pre>';
                
        if ($z === 1) {
            print '<span class="label label-success">Pass</span>' . "\n";
        }
        else {
            print '<span class="label label-danger">Fail</span>' . "\n";
        }
        
        print "<br><br>\n";
    }
}
