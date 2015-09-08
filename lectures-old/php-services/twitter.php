<?php

require_once("db.php");
require_once("service_util.php");

echo("<pre>\n");

$zzz = getPageCache("https://api.twitter.com/1/friends/ids.json?cursor=-1&screen_name=drchuck", 3600);

echo("OUTPUT:\n$zzz\n");
$data = json_decode($zzz);
// print_r($data);
$ids = $data->ids;
// print_r($ids);
$count = 0;
foreach ($ids as $id) {
  echo($id."\n");
  $count = $count + 1;
  if ( $count > 10 ) break;
  $url = "https://api.twitter.com/1/users/lookup.json?user_id=$id&include_entities=true";
  $user = json_decode(getPageCache($url, 3600));
  print_r($user);
}

?>