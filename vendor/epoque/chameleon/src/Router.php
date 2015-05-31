<?php
namespace Epoque\Chameleon;

/**
 * Router
 *
 * A static class for holding routes and handling route requests.
 */

class Router
{
    /** @var array Contains valid routes. **/
    private static $routes    = [];

    private static $htmlId = 'routerTestTable';


    private static function requestUri()
    {
        return 
        ltrim(filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_STRING), '/');
    }


    /**
     * route
     *
     * Includes a Route->response based upon self::requestUri.
     *
     * return void
     */

    public static function route()
    {
        $requestUri = self::requestUri();

        if (empty($requestUri)) {
            include VIEWS_DIR.DEFAULT_VIEW;
        }
        else {
            // for loop micro-optimization.
            for ($i = count(self::$routes), $match = false; $match === false && $i > 0;){
                if ($requestUri === self::$routes[--$i]->requestUri) {
                    $match = true;
                    include self::$routes[$i]->response;
                }
            }
        }
    }


    /**
     * addRoute
     *
     * Adds a given route to the routes array if valid.
     *
     * @param  Route   $route The given route.
     * @return Boolean True if given route is valid and added to
     *                 $this->routes, False otherwise.
     */

    public static function addRoute($route=null)
    {
        if (self::validRoute($route)) {
            array_push(self::$routes, $route);
        }
    }


    /**
     * validRoute
     *
     * Checks if a given route is considered valid.
     *
     * @param Route $route The given route.
     * @return Boolean True if the given route is valid, false otherwise.
     */

    private function validRoute($route)
    {
        if (empty($route->requestUri) || empty($route->response))
            return false;

        else if (is_file(APP_ROOT.$route->response) && !self::ignored($route))
            return true;

        else
            return false;
    }


    /**
     * ignored
     *
     * Checks the config file to see if the requested route should be ignored.
     *
     * @param Route $route a route object (see Route.php)
     * @return Boolean true  : If the path should be ignored
     *                 false : If the path should be processed
     */
 
    private function ignored($route) {
        $responseFile     = $route->responseFile;
        $ext            = pathinfo($responseFile)['extension'];
        $ignoredFiles   = [];
        $ignoredExt     = [];

        $ignoredFiles = array_merge($ignoredFiles, explode(' ', IGNORE_FILES));
        $ignoredExt   = array_merge($ignoredExt, explode(' ', IGNORE_EXT));
        
        if (in_array(basename($responseFile), $ignoredFiles))
            return true;
        
        else if (in_array($ext, $ignoredExt))
            return true;

        else
            return false;
        
    }


    /**
     * isView
     *
     * Checks wheather the given route is to a view.
     *
     * @param Route $route The given Route.
     * @return Boolean True if the route is to a view, false otherwise.
     */

    protected function isView($route)
    {
        $view = False;
        $tmp  = null;

        if (is_file(APP_ROOT.VIEWS_DIR.$route->response)) {
            $view = True;
        }
        else {
            $tmp = scandir(VIEWS_DIR);
            array_shift($tmp);
            array_shift($tmp);
        }

        return True;
    }


    public static function toHtml()
    {
        $string  = '<table id="'.self::$htmlId."\">\n";
        $string .= '<thead><tr><th>Router::routes Table</th></tr></thead>';
        $string .= '<tr><th>requestUri</th><th>response</th>';

        foreach (self::$routes as $route)
            $string .= "\t<tr><td>".$route->requestUri.'</td><td>'.$route->response."</td></tr>\n";

        $string .= '</table>';

        return $string;
    }
}
