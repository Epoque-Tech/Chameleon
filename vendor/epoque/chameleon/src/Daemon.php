<?php

namespace Epoque\Chameleon;


/**
 * Description of Daemon
 *
 * Used to control Chameleon projects.
 * 
 * @author jason favrod <jason@lakonacomputers.com>
 */

class Daemon
{
    private static $routes = [];


    public static function URI() {
        return filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL);
    }


    /**
     * addRoute
     *
     * Adds a route to the routes array.
     *
     * @param $route assoc_array Key is request, value is what it's
     * routed to.
     * @return boolean True if route array
     */

    public static function addRoute($route=[])
    {
        if (is_string(key($route)) && is_string(current($route))) {
            if (!array_key_exists(key($route), self::$routes)) {
                self::$routes[key($route)] = current($route);
                return true;
            }
            else {
                return false;
            }
        }
    }


    /**
     * fetchRequested
     *
     * Include file if URI is a key in routes array.
     *
     * @return mixed True if route included, null if fetchView is
     * called.
     */

    public static function fetchRequested()
    {
        $request = self::URI();

        if (array_key_exists($request, self::$routes)) {
            include self::$routes[$request];
            return true;
        }
        else {
            return self::fetchView();
        }
    }


    /**
     * fetchView
     * 
     * Used to include views from the VIEWS_DIR.
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


    /**
     * 
     * @param type $route
     * @return boolean
     */

    public static function isRoute($route=[])
    {   
        $r = false;
        
        if (is_array($route) && !empty($route)) {
            foreach (self::$routes as $req => $res) {
                if (key($route) === $req && current($route) === $res) {
                    $r = true;
                }
            }
        }
        
        return $r;
    }

}
