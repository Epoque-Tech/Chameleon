<?php
require 'config.php';


/**
 * RequestHandler
 * 
 * The default request handler for Chameleon projects.
 */

class RequestHandler
{
    /**
     * handle
     * 
     * Handles given requests.
     * 
     * @param associative array $request The $_REQUEST array.
     * @return type
     */
    
    public function handle(&$request)
    {
        return;
    }
    
}

if ($_REQUEST) {
    RequestHandler::handle($_REQUEST);
}
