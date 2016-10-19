<?php
namespace Epoque\ChameleonTesting;
use Epoque\Chameleon\HtmlHead;


/**
 * HtmlHeadTest
 *
 * @author jason favrod <jason@epoquecorportation.com>
 */

class HtmlHeadTest implements Test
{
    private static $htmlHead = null;
    private static $httpHost = null;
    
        private static $tests = [
        'Empty HtmlHead' => emptyTest,
        'Print HtmlHead' => printHtmlHead,
        'Test Adding a Title' => testAddTitle,
        'Add Keywords Test' => testAddKeywords,
        'Add Keywords Bad Args' => testAddKeywordsBadArgs,
        'Toggle Bootstrap' => removeBootstrapTest
    ];


    public static function run()
    {
        self::$htmlHead = trim(new HtmlHead(TRUE));
        self::$httpHost = filter_input(INPUT_SERVER, 'HTTP_HOST', FILTER_SANITIZE_URL);

        foreach (self::$tests as $header => $test) {
            print '<section class="col-md-8 col-md-offset-1 testSection">' . "\n";
            print "<h3>$header</h3>\n";
            $r = self::$test();
            if ($r) {
                print '<span class="label label-success">Pass</span>' . "\n";
            }
            else {
                print '<span class="label label-danger">Fail</span>' . "\n";
            }
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
            '<link rel="alternate" href="http://'.self::$httpHost.'/HtmlHeadTest" hreflang="en-us" /> ',
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
        
        $r > 0 ? $r = False : $r = True;
        return $r;
    }

    private static function printHtmlHead()
    {
        $z = 0;
        $z = print '<pre>' . htmlentities(self::$htmlHead) . '</pre>';
        if ($z === 1) {
            return True;
        }
        else {
            return False;
        }
    }


    private static function removeBootstrapTest()
    {
        $err = 0;

        self::$htmlHead = trim(new HtmlHead(TRUE));
        print "<pre>\n";

        HtmlHead::toggleBootstrap();
        self::$htmlHead = trim(new HtmlHead(TRUE));
        print "Turn off Bootstrap:\n" . htmlentities(self::$htmlHead);

        $err = !preg_match('|maxcdn.bootstrapcdn.com/bootstrap|', self::$htmlHead);

        HtmlHead::toggleBootstrap();
        self::$htmlHead = trim(new HtmlHead(TRUE));
        print "\n\nTurn On:\n" . htmlentities(self::$htmlHead) . "</pre>\n";

        $err = preg_match('|maxcdn.bootstrapcdn.com/bootstrap|', self::$htmlHead);

        return $err;
    }



    private static function testAddTitle()
    {
        $title = "TITLE";
        $err   = 0;
        
        print "<pre>\n";
        print "Head Before:\n" . htmlspecialchars(self::$htmlHead);
        
        $err = $err + preg_match('|MY_TITLE|', self::$htmlHead);
        
        HtmlHead::addTitle([Router::URI() => 'MY_TITLE']);
        $newHtmlHead = trim(new HtmlHead(TRUE));
        
        print "\n\nHead After:\n" . htmlspecialchars($newHtmlHead);
        print "</pre>\n";
        
        $err = $err + !preg_match('|MY_TITLE|', $newHtmlHead);
        
        return !$err;
    }


    private static function testAddKeywords()
    {
        $head = self::headToArray();
        $keywordsLine = -1;

        print "<pre>\n";

        foreach ($head as $i => $line) {
            if (preg_match('|<meta name="keywords"|', $line)) {
                $keywordsLine = $i;
                print 'keywords line before: ' . htmlspecialchars($line) . "\n";
            }
        }

        if ($i == -1) {
            print "Could not find keywords line in the HtmlHead!\n";
            print "</pre>\n";
            return FALSE;
        }
        else {
            HtmlHead::addKeywords([Router::URI() => 'KEYWORD']);
            $head = self::headToArray();
            print 'keywords line after: ' . htmlspecialchars($head[$keywordsLine]) . "\n";
            print "</pre>\n";
            return preg_match('|KEYWORD|', $head[$keywordsLine]);
        }
    }


    private static function testAddKeywordsBadArgs()
    {
        $err = 0;
        $args = [
            null,
            [],
            0,
            7,
            'keywords',
            ['keywords'],
            ['keywords' => 0],
            ['request' => 'key,words', '/' => 'more,key,words']
        ];

        print "<pre>\n";

        foreach ($args as $arg) {
            print 'Trying: ';

            if ($arg === null) {
                print 'null';
            }
            else if ($arg === []) {
                print '[]';
            }
            else if (is_array($arg) && !empty($arg)) {
                print_r($arg);
            }
            else {
                print "$arg";
            }

            print "\n";

            HtmlHead::addKeywords($arg);
            exec('tail -1 ' . LOG_FILE, $logline);

            if (!preg_match('|parameter not an array or array of larger than 1|', $logline[0]) &&
                    !preg_match('|keywords parameter ([<request> => <keywords>]) malformed|', $logline[0])) {
                $err++;
            }
        }

        print "</pre>\n";

        return !$err;
    }
}
