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
    public $request  = '';

    /** @var string The filesystem resources the request is mapped to. **/
    public $response = '';


    public function __construct($array)
    {
        if (is_array($array) && count($array) === 1) {
            $this->request  = key($array);
            $this->response = current($array);
        }
    }


    public function __toString()
    {
        $string  = 'Route(request: "'.$this->request.'", '; 
        $string .= 'response: "'.$this->response.'")';
        return $string;
    }
}

