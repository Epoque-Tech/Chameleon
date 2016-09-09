<?php
namespace Epoque\Chameleon;


/**
 * Description of Daemon
 *
 * Used to control Chameleon projects.
 *
 * @author jason favrod <jason@lakonacomputers.com>
 */

class Daemon extends Router
{
    /**
     * fetchView
     *
     * Used to include views from the VIEWS_DIR.
     */

    public static function fetchView() {
        $view = VIEWS_DIR . parent::URI() . '.php';

        if (is_file($view)) {
            include_once $view;
        }
        else if (is_file(DEFAULT_VIEW)) {
            include_once DEFAULT_VIEW;
        }
        else if (is_file(ERROR_404_FILE)) {
            include_once(ERROR_404_FILE);
        }
    }


    /**
     * contents
     *
     * An alias shorthand for `print file_get_contents()`.
     *
     * @param $file string The file to pass to file_get_contents
     */

    public static function contents($file='')
    {
        if (is_file($file)) {
            $s = file_get_contents($file);

            if (preg_match('|<?php|', $s)) {
                include $file;
            }
            else {
                print $s;
            }
        }
        else {
            parent::logWarning("Passed invalid file: '$file' to contents method");
        }
    }
}
