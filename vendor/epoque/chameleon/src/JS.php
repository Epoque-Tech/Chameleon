<?php
namespace Epoque\Chameleon;


/**
 * JS
 * 
 * Handles adding script tags based upon REQUEST_URI.
 *
 * @author jason favrod <jason@lakonacomputers.com>
 */

class JS extends Router
{
    static $BOOTSTRAP = '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>';
    static $jQuery    = '<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>';
    static $jQueryUI  = '<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>';


    /**
     * trio
     *
     * Prints the script tags for jQuery, jQuery-UI, and
     * Bootstrap JavaScript.
     */

    public static function trio()
    {
        $html  = '';

        $html .= "<!-- jQuery -->\n";
        $html .= self::$jQuery . "\n";
        $html .= "<!-- jQuery-UI -->\n";
        $html .= self::$jQueryUI . "\n";
        $html .= "<!-- Bootstrap JS -->\n";
        $html .= self::$BOOTSTRAP . "\n";

        print $html;
    }


    public static function tags($src)
    {
        $html = '';

        if (is_string($src)) {
            
            if ($src === 'trio') {
                self::trio();
            }
            else {
                $html = '<script src="';

                if (is_file(APP_ROOT.JS_DIR . $src)) {
                    $html .= JS_DIR . $src;
                }
                else if (is_file($src)) {
                    $html .= $src;
                }

                $html .= '"></script>'."\n";
            }
        }
        else if (is_array($src)) {
            foreach ($src as $source) {
                if ($source === 'trio') {
                    self::trio();
                }
                else {
                    $html .= '<script src="';

                    if (is_file(APP_ROOT.JS_DIR . $source)) {
                        $html .= JS_DIR . $source;
                    }
                    else if (is_file($source)) {
                        $html .= $source;
                    }

                    $html .= '"></script>'."\n";
                }
            }
        }

        print $html;
    }

    
    public static function fetchJavaScript() {
        if (array_key_exists(self::URI(), self::$routes)) {
            $js = str_replace(' ', '', self::$routes[self::URI()]);
            self::tags(explode(',', $js));
        }
        print_r(self::$routes[self::URI()]);
    }
}
