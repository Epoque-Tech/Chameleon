<?php

namespace Epoque\Chameleon;


/**
 * Description of Daemon
 *
 * @author jason favrod <jason@epoquecorportation.com>
 */
class Daemon
{
    /**
     * fetchView
     * 
     */

    public static function fetchView() {
        $view = VIEWS_DIR . self::URI() . '.php';
        
        //include_once VIEW_DIR.'homepage.php';
        
        if (is_file($view)) {
            include_once $view;
        }

        else if (is_file(VIEWS_DIR.'homepage.php')) {
            include_once VIEWS_DIR.'homepage.php';
        }
    }
    
    
    private static function URI() {
        return filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL);
    }
}
