<?php

require_once("db.php");
require_once("service_util.php");

echo("<pre>\n");

$data = getPageCache("http://www.dr-chuck.com/page1.htm", 10);

echo("OUTPUT:\n$data\n");
?>