<?php
namespace Epoque\Chameleon;


/**
 * Route
 *
 * An object that maps a requested path to a filesystem resource.
 *
 */

class Route
{
    /** @var string The requested path. **/
    public $requestUri  = '';

    /** @var string The filesystem resources the request is mapped to. **/
    public $response    = '';


    public function __construct($array)
    {
        if (is_array($array) && count($array) === 1) {
            $this->requestUri = key($array);
            $this->response   = current($array);
        }
    }


    public function __toString()
    {
        $string  = 'Route(requestUri: "'.$this->requestUri.'", '; 
        $string .= 'response: "'.$this->response.'")';
        return $string;
    }
}

