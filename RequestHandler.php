<?php
require_once 'config.php';
require_once 'vendor/autoload.php';
use Epoque\GitHub\Repos as Repos;
use Epoque\GitHub\Daemon as GitHub;

$token = trim(file_get_contents('github.token'));
GitHub::config(['user'=>'not--p', 'token'=> $token]);


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
        
        if (array_key_exists('github', $request)) {
            print self::githubSection();
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


    private static function price($x)
    {
        if ($x === 'gold') {
            $url = 'https://www.quandl.com/api/v1/datasets/LBMA/GOLD.json?rows=1';
            return json_decode(file_get_contents($url))->data[0][1];
        }
    }
    
    
    private static function githubSection()
    {
        $html = "<h2>GitHub Repos</h2>\n";
        foreach (Repos::enumerate() as $repo) {
            $html .= "\t<button ";
            $html .= 'id="'.$repo->name.'" type="button" class="repo-btn btn btn-primary">';
            $html .= "$repo->name</button>\n";
        }
        return $html . '<script src="'.JS_DIR.'github.js></script>'."\n";
    }
}

if ($_REQUEST) {
    RequestHandler::handle($_REQUEST);
}