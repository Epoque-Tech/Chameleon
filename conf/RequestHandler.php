<?php
require 'config.php';


/**
 * RequestHandler
 * 
 * The request handler template for Chameleon projects.
 */

class RequestHandler
{
    /**
     * handle
     * 
     * Handles requests.
     * 
     * @return tail call to an RequestHandler method.
     */
    
    public static function handle()
    {
        return;
    }
    
}

if ($_REQUEST) {
    RequestHandler::handle();
}
