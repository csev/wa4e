<?php
require_once("db.php");
require_once("service_util.php");

echo("<pre>\n");

$url = "http://www.si.umich.edu/rss.xml";
echo("RSS URL: $url\n");
$body = getPageCache($url,3600);
// echo($body);

$xml = new SimpleXMLElement($body);
// print_r($xml);
foreach($xml->channel->item as $item) {
echo("==================\n");
    //print_r($item);
    echo($item->title."\n");
}
?>
