<?php

if ( ! defined('COOKIE_SESSION') ) define('COOKIE_SESSION', true);

require_once "../tsugi/config.php";
require_once "Parsedown.php";

require_once "../top.php";
require_once "../nav.php";

if ( ! function_exists('endsWith') ) {
function endsWith($haystack, $needle) {
    // search forward starting from end minus needle length characters
    return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
}
}

$url = $_SERVER['REQUEST_URI'];

$pieces = explode('/',$url);

$file = false;
$contents = false;
if ( $pieces >= 2 ) {
   $file = $pieces[count($pieces)-1];
   if ( ! endsWith($file, '.md') ) $file = false;
   if ( ! $file || ! file_exists($file) ) $file = false;
}

if ( $file !== false ) {
    $contents = file_get_contents($file);
}

$OUTPUT->header();
?>
<style>
center {
    padding-bottom: 10px;
}
</style>
<?php
$OUTPUT->bodyStart();
$OUTPUT->topNav();

if ( $contents != false ) {
    $Parsedown = new Parsedown();
    echo $Parsedown->text($contents);
} else {
?>
<ul>
<li><a href="ngrok_mac.md">Using ngrok</a></li>
</ul>
<?php
}
$OUTPUT->footer();
