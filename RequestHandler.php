<?php


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
    
    public static function handle(&$request)
    {
        if (array_key_exists('top-news', $request)) {
            print self::news('https://news.google.com/news?cf=all&hl=en&pz=1&ned=us&output=rss');
        }
        
        if (array_key_exists('biz-news', $request)) {
            print self::news('https://news.google.com/news?cf=all&hl=en&pz=1&ned=us&topic=b&output=rss');
        }
        
        if (array_key_exists('world-news', $request)) {
            print self::news('https://news.google.com/news?cf=all&hl=en&pz=1&ned=us&topic=w&output=rss');
        }
        
    }
    
    
    private static function news($newsRSS)
    {
        $newsFeed = new SimpleXMLElement(file_get_contents($newsRSS));
        $newsItem = $newsFeed->xpath('//item');
        $html     = '';
        
        foreach ($newsItem as $item) {
            $html .= '<h4>&middot; <a href="'.$item->link.'" target="_blank">';
            $html .= preg_split('/ - /', $item->title)[0].'</a></h4>';
        }
        
        return $html;
    }

}

if ($_REQUEST) {
    RequestHandler::handle($_REQUEST);
}