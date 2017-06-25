<?php
if ($_SERVER['REMOTE_ADDR'] !== '72.234.164.107') die('invalid request location');
require pathinfo(pathinfo(__DIR__)['dirname'])['dirname'] . '/config.php';

use Epoque\Chameleon\Common as Chameleon;
use Epoque\PHP\Common;
use Epoque\PHP\FileReader;
use cebe\markdown\GithubMarkdown as MD;


/* The directory containing the drafts. */
define('DRAFTS_DIR', APP_ROOT.'resources/posts/draft/');

/* The directory containing the drafts. */
define('PUB_DIR', APP_ROOT.'resources/posts/pub/');

/* A container for holding draft file locations. */
$drafts = [];

/* A container for holding draft file locations. */
$pub = [];


$request = filter_input_array(INPUT_GET, [
    'draft/links' => FILTER_SANITIZE_STRING,
    'post/links' => FILTER_SANITIZE_STRING,
    'draft/id' => FILTER_SANITIZE_STRING,
    'draft/preview' => FILTER_SANITIZE_STRING
]);


// Store drafts in associative array keyed to modification time.

foreach ([DRAFTS_DIR => 'drafts', PUB_DIR => 'pub'] as $dir => $container) {
    foreach (Common::dirscan($dir) as $draft) {
        $GLOBALS[$container][filemtime($dir.$draft)] = $dir.$draft;
    }
}

// Sort the array from soonest first.
krsort($drafts);


if ($request['draft/links'] === 'true')
{
    foreach ($drafts as $modtime => $draft) {
        $title = (new FileReader($draft))->readln();
        $title = str_replace('## ', '', $title);
        $draft_links .= '<button type="button" class="btn btn-default" id="'.$modtime.'">'.$title."</button>\n";
    }
    
    print $draft_links;
}


else if ($request['pub/links'] === 'true')
{
    foreach ($pub as $modtime => $draft) {
        $title = (new FileReader($draft))->readln();
        $title = str_replace('## ', '', $title);
        $draft_links .= '<button type="button" class="btn btn-default" id="'.$modtime.'">'.$title."</button>\n";
    }
    
    print $draft_links;
}


else if (preg_match('|\d+|', $request['draft/id']))
{
    $id = $request['draft/id'];
    $fr = new FileReader($drafts[$id]);

    $line = $fr->readln();
    while ($line !== false) {
        $draft_content .= $line . "\n";
        $line = $fr->readln();
    }

    print $draft_content;
}


else if (is_string($request['draft/preview']))
{
    $parser = new MD();
    print $parser->parse($request['draft/preview']);
}


