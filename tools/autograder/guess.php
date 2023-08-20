<?php

require_once "../config.php";
require_once "webauto.php";
use \Tsugi\Util\Mersenne_Twister;

line_out("Grading DJ4E Guessing Assignment (GET)");

// Compute the stuff for the output
$code = $USER->id+$LINK->id+$CONTEXT->id;
$MT = new Mersenne_Twister($code);
$correct = $MT->getNext(12,82);

?>
<p>Assignment specification:
<a href="http://www.wa4e.com/assn/guess/" target="_blank">http://www.wa4e.com/assn/guess/</a></p>
<p>For this assignment, each student is given a different "correct" answer which must be used
in your code.
</p>
<p>
<b>
Note: Your assignment must accept <?= $correct ?> as the correct
answer to complete this assignment with full credit.
</b>
</p>
<?php
titleNote();

$url = getUrl('http://www.wa4e.com/code/arrays/guess.php');
if ( $url === false ) return;
$grade = 0;

error_log("Guess/GET ".$url);
flush();

webauto_setup();

// Yes, one gigantic unindented try/catch block
$passed = 5;
$titlefound = false;
try {

$crawler = webauto_get_url($client, $url);
if ( $crawler === false ) return;
$html = webauto_get_html($crawler, true);

    $retval = webauto_check_title($crawler);
    if ( $retval === true ) {
        $titlefound = true;
    } else {
        error_out($retval);
    }

    line_out("Looking for 'Missing guess parameter'");
    if ( stripos($html, 'Missing guess parameter') > 0 ) $passed++;
    else error_out("Not found");

    // Empty guess
    $u = $url . "?guess=";
$crawler = webauto_get_url($client, $u);
if ( $crawler === false ) return;
$html = webauto_get_html($crawler, true);
line_out("Looking for 'Your guess is too short");
if ( stripos($html, 'Your guess is too short') > 0 ) $passed++;
else error_out("Not found");

// Bad guess
$u = $url . "?guess=fred";
$crawler = webauto_get_url($client, $u);
if ( $crawler === false ) return;
$html = webauto_get_html($crawler, true);
line_out("Looking for 'Your guess is not a number");
if ( stripos($html, 'Your guess is not a number') > 0 ||
     stripos($html, 'Your guess is not valid') > 0 ) $passed++;
else error_out("Not found");

// Low guess
$u = $url . "?guess=".($correct-1);
$crawler = webauto_get_url($client, $u);
if ( $crawler === false ) return;
$html = webauto_get_html($crawler, true);
line_out("Looking for 'Your guess is too low'");
if ( stripos($html, 'Your guess is too low') > 0 ) $passed++;
else error_out("Not found");

// High guess
$u = $url . "?guess=".($correct+1);
$crawler = webauto_get_url($client, $u);
if ( $crawler === false ) return;
$html = webauto_get_html($crawler, true);
line_out("Looking for 'Your guess is too high'");
if ( stripos($html, 'Your guess is too high') > 0 ) $passed++;
else error_out("Not found");

// Good guess
$u = $url . "?guess=".$correct;
$crawler = webauto_get_url($client, $u);
if ( $crawler === false ) return;
$html = webauto_get_html($crawler, true);
line_out("Looking for 'Congratulations - You are right'");
if ( stripos($html, 'congratulations') > 0 ) $passed++;
else error_out("Not found");

} catch (Exception $ex) {
    error_out("The autograder did not find something it was looking for in your HTML - test ended.");
    error_out("Usually the problem is in one of the pages returned from your application.");
    error_out("Use the 'Toggle' links above to see the pages returned by your application.");
    echo("<!--\n");
    error_log($ex->getMessage());
    error_log($ex->getTraceAsString());
    $detail = "This indicates the source code line where the test stopped.\n" .
        "It may not make any sense without looking at the source code for the test.\n".
        'Caught exception: '.$ex->getMessage()."\n".$ex->getTraceAsString()."\n";
    showHTML("Internal error detail.",$detail);
    echo("\n-->\n");
}

$perfect = 11;
$score = webauto_compute_effective_score($perfect, $passed, $penalty);

if ( ! $titlefound ) {
    error_out("These pages do not have proper titles so this grade was not sent");
    return;
}

if ( $score > 0.0 ) webauto_test_passed($score, $url);

