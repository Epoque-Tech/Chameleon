<?php

$newsFeed = new SimpleXMLElement(file_get_contents('https://news.google.com/news?cf=all&hl=en&pz=1&ned=us&output=rss'));
$newsItem = $newsFeed->xpath('//item');


print "<h3>Top Stories</h3>\n";
foreach ($newsItem as $item) {
    print '<a href="'.$item->link.'" target="_blank">'.$item->title."</a><br><br>\n";
}

