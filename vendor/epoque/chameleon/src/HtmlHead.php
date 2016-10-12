<?php

/**
 * HtmlHead
 * 
 * Encapsulates dynamic HTML head data, and provides a printable
 * __toString method for printing the relevent head data.
 * 
 * @author Jason Favrod jason@lakonacomputers.com
 */

namespace Epoque\Chameleon;


class HtmlHead
{
    /** @var array Contains HTML document meta description arrays. **/
    private static $description = [];

    /** @var array Contains HTML document meta keywords arrays. **/
    private static $keywords    = [];
    
    /** @var array Contains HTML document title arrays. **/
    private static $title       = [];

    /** @var array Contains key/value pairs for view specific css. **/
    private static $css         = [];
    
    /** @var array Contains URL linking to CSS for all views. **/
    private static $globalCss   = [];
    
    /** @var array List of elements that can be set to TRUE to disable **/
    private static $disabled    = [ 'bootstrap' => FALSE,
                                    'jquery'    => FALSE,
                                    'jquery-ui' => FALSE ];

    
    public function __construct($test=FALSE)
    {
        if ($test==FALSE) {
            print self::__toString();
        }
        else {
            return self::__toString();
        }
    }


    /**
     * disable
     *
     * Disables the given $element.
     *
     * @param string $element The element of the self::$disabled array
     * to disable. Possible values 'bootstrap', 'jquery', 'jquery-ui'.
     */

    public static function disable($element)
    {
        if (!self::$disabled[$element]) {
            self::$disabled[$element] = TRUE;
        }
    }


    /**
     * addKeywords
     * 
     * Add an array representing mapping of request => keywords to
     * the keywords array.
     * 
     * @param type $keywords
     * @return boolean
     */

    public static function addKeywords($keywords=[]) {
        $result = false;

        if (is_array($keywords) && count($keywords) === 1) {

            if ((is_string(key($keywords)) || key($keywords) === '') && is_string(current($keywords))) {
                self::$keywords = array_merge(self::$keywords, $keywords);
                $result = true;
            }
        }

        return $result;
    }


    /**
     * addDescription
     * 
     * Add an array representing mapping of request => description to
     * the description array.
     * 
     * @param type $description
     * @return boolean
     */

    public static function addDescription($description=[]) {
        $result = false;

        if (is_array($description) && count($description) === 1) {

            if ((is_string(key($description)) || key($description) === '') && is_string(current($description))) {
                self::$description = array_merge(self::$description, $description);
                $result = true;
            }
        }

        return $result;
    }


    /**
     * addTitle
     *
     * Adds valid title arrays to the class' title array.
     *
     * @param  array $title A [(string) requestUri => (string) title]
     * mapping.
     * @return Boolean True if title was added, false otherwise.
     */

    public static function addTitle($title=[])
    {
        $result = false;

        if (is_array($title) && count($title) === 1) {

            if ((is_string(key($title)) || key($title) === '') && is_string(current($title))) {
                self::$title = array_merge(self::$title, $title);
                $result = true;
            }
        }

        return $result;
    }


    /**
     * addCss
     *
     * Add a key/value pair where the key is a request URI and the
     * value is the CSS to load.
     * 
     * Key (request URI) Must be in the VIEWS_DIR (without '.php'),
     * or it can be an empty string (for the homepage).
     * 
     * @param array $css An associative array mapping a request URI
     * key to a URL of a CSS to load for that request.
     */

    public static function addCss($css=[])
    {
        if (is_array($css) && (is_file(VIEWS_DIR.key($css).'.php') || key($css) === '') &&
                is_string(current($css))) {
            
            if (empty(self::$css[key($css)])) {
                self::$css[key($css)] = [current($css)];
            }
            else {
                array_push(self::$css[key($css)], current($css));
            }
        }
    }


    /**
     * addGlobalCss
     * 
     * Adds a URL to the $globalCss array that will be in the HTML head of
     * every view.
     *
     * @param  string $css A given URL.
     * @return Boolean True if $css was added to self::$css.
     */

    public static function addGlobalCss($css='')
    {
        return array_push(self::$globalCss, $css);
    }

     
    public function __toString()
    {
        $requestUri = ltrim(filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL), '/');
        $requiredJS = ['config.js', 'chameleon.js'];

        // MetaData

        $html  = "<meta charset=\"utf-8\">\n";
        $html .= "<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\n";
        $html .= "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">\n";
        $html .= '<meta name="description" content="'.self::$description[$requestUri].'">'."\n";
        $html .= '<meta name="keywords" content="'.self::$keywords[$requestUri].'">'."\n";
        $html .= "<meta name=\"author\" content=\"\">\n";
        $html .= '<link rel="alternate" href="http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'" hreflang="en-us" /> '."\n";

        
        // Site/View Title

        if (array_key_exists($requestUri, self::$title))
            $html .= '<title>' . self::$title[$requestUri] . "</title>\n";
        else
            $html .= '<title>'.SITE_TITLE."</title>\n";

        
        // CSS
        
        if (!self::$disabled['bootstrap']) {
            $html .= '<link rel="stylesheet" '.
                     'href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" '.
                     'integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" '.
                     'crossorigin="anonymous">'."\n";
        }

        if (!empty(self::$globalCss)) {
            foreach (self::$globalCss as $url) {
                $html .= "<link href=\"$url\" rel=\"stylesheet\">\n";
            }
        }
        
        if (array_key_exists($requestUri, self::$css)) {
            foreach (self::$css[$requestUri] as $css) {
                $html .= '<link href="'.$css.'" rel="stylesheet">'."\n";
            }
        }

        return "<head>\n$html</head>\n";
    }
}

