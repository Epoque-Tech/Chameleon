<?php
namespace Epoque\Chameleon;


/**
 * Description of Daemon
 *
 * Used to control Chameleon projects.
 * 
 * @author jason favrod <jason@lakonacomputers.com>
 */

class Daemon extends Common
{
    protected static $routes = [];


    public static function URI() {
        return filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL);
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
     * printJSTrio
     * 
     * Prints the script tags for jQuery, jQuery-UI, and
     * Bootstrap JavaScript.
     */
    
    public static function printJSTrio()
    {
        print <<<HTML
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<!-- jQuery-UI -->
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
HTML;
    }
}
