<?php

header("Content-Type: text/plain; charset=utf-8");

$dirname = dirname(__DIR__);
require_once $dirname."/tsugi/config.php";

$marker_file = __DIR__."/cron.txt";

$now = time();
if ( file_exists($marker_file) ) {
   $file_time = filemtime($marker_file);
   $delta = time() - $file_time;
} else {
    $delta = 24*60*60;
}

/* ------------- Actual cron --------------- */

$ZIP_TIME = 30*60; // 30 Minutes

if ( $delta > $ZIP_TIME ) {
    echo("Running command\n");
    echo(system("cd ../code ; bash zips.sh"));
    echo("\n");
    touch($marker_file);
} else {
    echo("Delta $delta z:$ZIP_TIME\n");
}


