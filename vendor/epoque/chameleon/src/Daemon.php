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
    
    
    private static function URI() {
        return filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL);
    }
}
