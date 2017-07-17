<?php
require pathinfo(pathinfo(__DIR__)['dirname'])['dirname'] . '/config.php';

use Epoque\PHP\SQLite3DB as db;
use cebe\markdown\GithubMarkdown as MD;

define('DRAFTS', APP_ROOT.'resources/sql/drafts.db');

// TODO: Change the way drafts are saved. Save to DB.

$request = [];

$request['get'] = filter_input_array(INPUT_GET, [
    'index' => FILTER_SANITIZE_URL
]);

$request['post'] = filter_input_array(INPUT_POST, [
    '/save/unpub/new' => FILTER_SANITIZE_STRING & FILTER_FLAG_NO_ENCODE_QUOTES,
    '/save/unpub/exist' => FILTER_SANITIZE_STRING & FILTER_FLAG_NO_ENCODE_QUOTES
]);


if (isset($request['get']['index']))
{
    $db = new db(DRAFTS);
    $sql = 'SELECT id,title,published,mod_epoque FROM drafts;';
    print json_encode($db->select($sql));
}


else if ($unpub_new = json_decode($request['post']['/save/unpub/new']))
{
    $db = new db(DRAFTS);
    
    $mod_timestamp = date(DateTime::ISO8601);
    $mod_epoque = date('U');
    $id = (function() {global $id; return preg_replace('|[a-f]|', '', md5($id));})();
    $title = \SQLite3::escapeString($unpub_new->title);
    $content = \SQLite3::escapeString($unpub_new->content);
    
     $sql = 'INSERT INTO drafts (id, published, mod_timestamp, mod_epoque, title,'
             . ' content) VALUES (';
     $sql .= "'$id', 0, '$mod_timestamp', $mod_epoque, '$title', '$content');";
     
     if ($db->insert($sql)) {
         header("HTTP/1.1 200 OK");
         print $id;
     }
     else {
         header("HTTP/1.1 500 Internal Sqlite3 Error");
     }
}

else if ($unpub_new = json_decode($request['post']['/save/unpub/exist']))
{
    $db = new db(DRAFTS);
    
    $mod_timestamp = date(DateTime::ISO8601);
    $mod_epoque = date('U');
    $id = (function() {global $id; return preg_replace('|[a-f]|', '', md5($id));})();
    $title = \SQLite3::escapeString($unpub_new->title);
    $content = \SQLite3::escapeString($unpub_new->content);
    
     $sql = 'INSERT INTO drafts (id, published, mod_timestamp, mod_epoque, title,'
             . ' content) VALUES (';
     $sql .= "'$id', 0, '$mod_timestamp', $mod_epoque, '$title', '$content');";
     
     if ($db->insert($sql)) {
         header("HTTP/1.1 200 OK");
         print $id;
     }
     else {
         header("HTTP/1.1 500 Internal Sqlite3 Error");
     }
}