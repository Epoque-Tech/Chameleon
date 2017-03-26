<?php
namespace Epoque\Chameleon;


/**
 * Description of Daemon
 *
 * Used to control Chameleon projects.
 *
 * @author jason favrod <jason@epoquecorporation.com>
 */

class Daemon extends Router
{
    /**
     * fetchView
     *
     * Used to include views from the VIEWS_DIR.
     */

    public static function fetchView() {
        $view = self::$routes[self::URI()];

        if (is_file($view)) {
            include_once $view;
        }
        else if (is_file(VIEWS_DIR . self::URI() . '.php')) {
            include VIEWS_DIR . self::URI() . '.php';
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

    
    /**
     * dirscan
     * 
     * @param type $dir
     * @param type $args
     * @return type
     */
    
    public static function dirscan($dir, $args=[]) {
        $dirscan = scandir($dir);
        $ignored = [];
        if (empty($args['dots'])) {
            $ignored = ['.', '..'];
        }
        if (!empty($args['ignored'])) {
            $ignored = array_merge($ignored, $args['ignored']);
        }
        $i = 0;
        foreach($dirscan as $item) {
            if (in_array($item, $ignored)) {
                unset($dirscan[$i]);
            }
            $i++;
        }
        return $dirscan;
    } 
}
