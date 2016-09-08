<?php
require_once 'config.php';
require_once 'vendor/autoload.php';
require_once PHP_DIR.'CPI.php';

use Epoque\GitHub\Repos as Repos;
use Epoque\GitHub\Daemon as GitHub;

$token = trim(file_get_contents('github.token'));
GitHub::init(['user'=>'not--p', 'token'=> $token]);


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
        
        if (array_key_exists('years-indexed', $request)) {
            print self::yearsIndexed();
        }
        
        if (array_key_exists('github', $request)) {
            print self::githubSection($request['github']);
        }
        
        if (array_key_exists('getShoppingList', $request)) {
            print file_get_contents(APP_ROOT.JS_DIR.'shoppingList.json');
        }
        
        if (array_key_exists('updateShoppingList', $request)) {
            if (file_put_contents(
                APP_ROOT.JS_DIR.'shoppingList.json',
                json_encode($request['updateShoppingList']))
            ) {
                print "Shopping list updated.";
            }
            else {
                print "Failed to update shopping list.";
            }
        }
        
        if (array_key_exists('updateEmptyShoppingList', $request)) {
            if (file_put_contents(APP_ROOT.JS_DIR.'shoppingList.json', "{}")) {
                print "Shopping list updated.";
            }
            else {
                print "Failed to update shopping list.";
            }
        }

        if (array_key_exists('getTodoList', $request)) {
            print file_get_contents(APP_ROOT.JS_DIR.'todoList.json');
        }
        
        if (array_key_exists('updateTodoList', $request)) {
            if (file_put_contents(
                APP_ROOT.JS_DIR.'todoList.json',
                json_encode($request['updateTodoList']))
            ) {
                print "Todo list updated.";
            }
            else {
                print "Failed to update todo list.";
            }
        }
        
        if (array_key_exists('updateEmptyTodoList', $request)) {
            if (file_put_contents(APP_ROOT.JS_DIR.'todoList.json', "{}")) {
                print "Todo list updated.";
            }
            else {
                print "Failed to update todo list.";
            }
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


    private static function yearsIndexed()
    {
        $years = '';

        foreach (CPI::$index as $year => $val) {
            $years .= $year . ',';
        }

        return rtrim($years, ',');
    }


    private static function price($x)
    {
        if ($x === 'gold') {
            $url = 'https://www.quandl.com/api/v1/datasets/LBMA/GOLD.json?rows=1';
            return json_decode(file_get_contents($url))->data[0][1];
        }
    }
    
    
    private static function githubSection($args)
    {
        $args = explode(',', $args);
        $html = '';
        
        if ($args[0] === 'section') {
            $html .= "<h2>GitHub Repos</h2>\n";
            foreach (Repos::enumerate() as $repo) {
                $html .= "\t<button ";
                $html .= 'id="'.$repo->name.'" type="button" class="repo-btn btn btn-primary">';
                $html .= "$repo->name</button>\n";
            }
        }
        else if ($args[0] === 'branch') {
            foreach (Repos::branches($args[1]) as $branchObj) {
                $html .= '<p><a href="'.$branchObj->commit->url.'">'.$branchObj->name."</a></p>\n";
            }
        }
        
        return $html . '<script src="'.JS_DIR.'github.js></script>'."\n";
    }
}

if ($_REQUEST) {
    RequestHandler::handle($_REQUEST);
}