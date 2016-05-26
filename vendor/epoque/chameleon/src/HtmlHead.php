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

    /** @var array Contains URL linking to CSS. **/
    private static $css         = [];

    /** @var array Contains URL link to JavaScripts. **/
    private static $js          = [];

    
    public function __construct()
    {
        print self::__toString();
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
     * Adds a URL to the $css array.
     *
     * @param  string $css A given URL.
     * @return Boolean True if $css was added to self::$css.
     */

    public static function addCss($css='')
    {
        return array_push(self::$css, $css);
    }


    /**
     * addJs
     *
     * @param string $js A given URL.
     * @return Boolean True if $js was added to self::js.
     */

     public static function addJs($js='')
     {
        return array_push(self::$js, $js);
     }


    public function __toString()
    {
        $title      = '<title>'.SITE_TITLE."</title>\n";
        $requestUri =
            ltrim(filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL), '/');

        $html  = "<meta charset=\"utf-8\">\n";
        $html .= "<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\n";
        $html .= "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">\n";
        $html .= '<meta name="description" content="'.self::$description[$requestUri].'">'."\n";
        $html .= '<meta name="keywords" content="'.self::$keywords[$requestUri].'">'."\n";
        $html .= "<meta name=\"author\" content=\"\">\n";

        $html .= '<link rel="alternate" href="http://'.$_SERVER['HTTP_HOST'].'" hreflang="en-us" /> '."\n";

        if (array_key_exists($requestUri, self::$title)) {
            $html .= '<title>' . self::$title[$requestUri] . "</title>\n";
        } else {
            $html .= $title;
        }
        
        $html .= '<link rel="stylesheet" '
                . 'href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" '
                . 'integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" '
                . 'crossorigin="anonymous">'."\n";
        
        $html .= '<script src="https://code.jquery.com/jquery-2.2.0.min.js"></script>'."\n";
        $html .= '<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>'."\n";
        $html .= '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>'."\n";

        if (file_exists(APP_ROOT.JS_DIR.'config.js')) {
            $html .= '<script src="'.JS_DIR.'config.js"></script>'."\n";
        }

        // Backslashes were put there on purpose.
        
        if (!empty(self::$css)) {
            foreach (self::$css as $url) {
                $html .= "<link href=\"$url\" rel=\"stylesheet\">\n";
            }
        }

        if (!empty(self::$js)) {
            foreach (self::$js as $url) {
                $html .= "<script src=\"$url\"></script>\n";
            }
        }

        return "<head>\n$html</head>\n";
    }
}

