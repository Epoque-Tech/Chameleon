<?php
require pathinfo(pathinfo(__DIR__)['dirname'])['dirname'] . '/config.php';

use Epoque\PHP\SQLite3DB as db;
use cebe\markdown\GithubMarkdown as MD;

define('DRAFTS', APP_ROOT.'resources/sql/drafts.db');


$request = [];

$request['get'] = filter_input_array(INPUT_GET, [
    'index' => FILTER_SANITIZE_URL,
    '/draft/unpub' => FILTER_SANITIZE_STRING
]);

$request['post'] = filter_input_array(INPUT_POST, [
    '/save/unpub/new' => FILTER_SANITIZE_STRING & FILTER_FLAG_NO_ENCODE_QUOTES,
    '/save/unpub/exist' => FILTER_SANITIZE_STRING & FILTER_FLAG_NO_ENCODE_QUOTES
]);

$request['delete'] = [];
if (filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING) === 'DELETE') {
    $query = filter_input(INPUT_SERVER, 'QUERY_STRING', FILTER_SANITIZE_STRING);
    $query = explode('=', $query);
    
    $request['delete'][$query[0]] = $query[1];

}


if (isset($request['get']['index']))
{
    $db = new db(DRAFTS);
    $sql = 'SELECT id,title,published,mod_epoque FROM drafts;';
    print json_encode($db->select($sql));
}


else if (isset($request['get']['/draft/unpub']))
{
    $db = new db(DRAFTS);
    $draftId = $request['get']['/draft/unpub'];
    $sql = "SELECT title,content FROM drafts WHERE id ='$draftId'";

    print json_encode($db->select($sql)[0]);
}


else if ($unpub_new = json_decode($request['post']['/save/unpub/new']))
{
    $db = new db(DRAFTS);
    
    $mod_timestamp = date(DateTime::ISO8601);
    $mod_epoque = date('U');
    $title = \SQLite3::escapeString($unpub_new->title);
    $content = \SQLite3::escapeString($unpub_new->content);
    $id = str_replace(' ', '', strtolower($title));
    
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

else if ($request['delete']['draft'])
{
    $db = new db(DRAFTS);
    
    $draftId = $request['delete']['draft'];
    $sql = "DELETE FROM drafts WHERE id='$draftId';";
    
    $db->insert($sql);
}
