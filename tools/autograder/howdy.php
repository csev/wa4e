<?php

require_once "webauto.php";

line_out("Grading WA4E Assignment 2");

titleNote();

$url = getUrl('http://csevumich.byethost18.com/howdy.php');
if ( $url === false ) return;
$grade = 0;

line_out("Retrieving ".htmlent_utf8($url)."...");
flush();

webauto_setup();

$crawler = webauto_get_url($client, $url);
if ( $crawler === false ) return;
$html = webauto_get_html($crawler);

line_out("Searching for h1 tag...");

$passed = 0;
$titlefound = false;
try {
    $h1 = $crawler->filterXPath('//h1')->text();
    line_out("Found h1 tag...");
} catch(Exception $ex) {
    error_out("Did not find h1 tag");
    $h1 = "";
}

if ( stripos($h1, 'Hello') !== false ) {
    success_out("Found 'Hello' in the h1 tag");
    $passed += 1;
} else {
    error_out("Did not find 'Hello' in the h1 tag");
}

if ( $USER->displayname && stripos($h1,$USER->displayname) !== false ) {
    success_out("Found ($USER->displayname) in the h1 tag");
    $passed += 1;
} else if ( $USER->displayname ) {
    error_out("Did not find $USER->displayname in the h1 tag");
    error_out("No score sent");
    return;
}

$perfect = 2;
$score = webauto_compute_effective_score($perfect, $passed, $penalty);

// Send grade
if ( $score > 0.0 ) webauto_test_passed($score, $url);

