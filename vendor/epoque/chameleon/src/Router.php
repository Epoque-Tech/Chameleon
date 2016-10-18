<?php
namespace Epoque\Chameleon;

/**
 * Router
 * 
 * @author jason favrod <jason@lakonacomputers.com>
 */

abstract class Router extends Common
{
    protected static $routes = [];
    
    
    public static function URI() {
        return rtrim(filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL), '/');
    }


    /**
     * isRoute
     *
     * Checks if a given route (assoc_array) is in the routes array.
     *
     * @param assoc_array $route A route to check.
     * @return boolean True if in array, false otherwise.
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
            if (!self::isRoute($route)) {
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
            return self::$routes[$request];
        }
    }
}
