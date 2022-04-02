<?php

require_once "../config.php";
require_once "webauto.php";
require_once "words.php";
shuffle($WORDS);
use Goutte\Client;

line_out("Grading PHP-Intro CRUD");

$url = getUrl($reference_implementation);
if ( $url === false ) return;
$grade = 0;

error_log($title_plural." ".$url);
line_out("Retrieving ".htmlent_utf8($url)."...");
flush();

$client = new Client();
$client->setMaxRedirects(5);
$client->getClient()->setSslVerification(false);

// Make up some good submit data
$wcount = 1;
$submit = array();
$empty_submit = array();
$fieldlist = "";
$firstint = False;
$firstintfield = False;
$firststring = False;
$firststringfield = False;
$firstemailfield = False;
foreach($fields as $field ) {
    if ( strlen($fieldlist) > 0 ) $fieldlist .= ', ';
    $fieldlist .= $field[1];
    $v2 = isset($field[3]) ? $field[3] : false;
    $empty_submit[$field[1]] = "";
    if ( $field[2] == 'e' ) {
        $submit[$field[1]] = "blah@example.com";
    } else if ( $field[2] == 'i' ) {
        $submit[$field[1]] = rand(5,99);
        if ( $firstintfield === False ) $firstintfield = $field[1];
        if ( $firstint === False ) $firstint = $submit[$field[1]];
    } else if ( is_numeric($v2) ) {
        $submit[$field[1]] = substr(ucwords($WORDS[$wcount]),0,$v2+0);
        if ( $firststringfield === False ) $firststringfield = $field[1];
        if ( $firststring === False ) $firststring = $submit[$field[1]];
        $wcount++;
    } else {
        $submit[$field[1]] = ucwords($WORDS[$wcount]);
        if ( $firststringfield === False ) $firststringfield = $field[1];
        if ( $firststring === False ) $firststring = $submit[$field[1]];
        $wcount++;
    }
}

// Yes, one gigantic unindented try/catch block
$passed = 0;
$titlefound = true;
try {

$crawler = $client->request('GET', $url);

$html = webauto_get_html($crawler);
markTestPassed('Index retrieved');

$retval = webauto_check_title($crawler);
if ( $retval !== true ) {
    error_out($retval);
    $titlefound = false;
}

line_out("Looking for  an anchor tag with text of 'Please log in' (case matters)");
$link = $crawler->selectLink('Please log in')->link();
$url = $link->getURI();
line_out("Retrieving ".htmlent_utf8($url)."...");
$crawler = $client->request('GET', $url);
markTestPassed('login page retrieved');
$html = $crawler->html();
showHTML("Show retrieved page",$html);

// Doing a log in
line_out('Looking for the form with a value="Log In" submit button');
$form = webauto_get_form_button($crawler,'Log In');
line_out("-- this autograder expects the log in form field names to be:");
line_out("-- email and pass");
line_out("-- umsi@umich.edu / php123");
line_out("-- if your fields do not match these, the next tests will fail.");
$form->setValues(array("email" => "umsi@umich.edu", "pass" => "php123"));
$crawler = $client->submit($form);
markTestPassed('Submit to login.php');
checkPostRedirect($client);
$html = $crawler->html();
showHTML("Show retrieved page",$html);


line_out("Looking for anchor tag with 'Add New Entry' as the text");
$link = $crawler->selectLink('Add New Entry')->link();
$url = $link->getURI();
line_out("Retrieving ".htmlent_utf8($url)."...");

$crawler = $client->request('GET', $url);
$html = $crawler->html();
markTestPassed('Retrieve add.php');
showHTML("Show retrieved page",$html);

// Add new fail
line_out('Looking for the form with a value="Add" submit button in add.php');
$form = webauto_get_form_button($crawler,'Add');
line_out("-- this autograder expects the form field names to be:");
line_out("-- ".$fieldlist);
line_out("-- if your fields do not match these, the next tests will fail.");
line_out("Leaving all the fields empty to cause an error.");
$form->setValues($empty_submit);
$crawler = $client->submit($form);
markTestPassed('Form submitted');
checkPostRedirect($client);
$html = $crawler->html();
showHTML("Show retrieved page",$html);

line_out("Expecting 'All fields are required'");
if ( strpos(strtolower($html), 'fields are required') !== false ) {
    markTestPassed('Found error message');
} else {
    error_out("Could not find 'All fields are required' in add.php");
    error_out("It is a good practice to put the 'All fields are required' check before the other checks (like is_numeric)");
    return;
}

// Add new success
line_out('Looking for the form with a value="Add" submit button in add.php');
$form = webauto_get_form_button($crawler,'Add');
line_out("-- this autograder expects the form field names to be:");
line_out("-- ".$fieldlist);
line_out("-- if your fields do not match these, the next tests will fail.");
line_out("Submitting good data.");
$form->setValues($submit);
$crawler = $client->submit($form);
markTestPassed('Form data submitted');
checkPostRedirect($client);
$html = $crawler->html();
showHTML("Show retrieved page",$html);

line_out("Expecting 'added'");
if ( strpos(strtolower($html), 'added') !== false ) {
    markTestPassed('Found success message after add');
} else {
    error_out("Could not find 'added'");
    return;
}


line_out("Looking '$firststring' entry in index.php");
$pos = strpos($html, $firststring);
if ( $pos > 1 ) {
    markTestPassed("Found '$firststring' entry in index.php");
} else {
    error_out("Could not find '$firststring' entry in index.php");
    return;
}
$pos2 = strpos($html, "edit.php", $pos);

line_out("Looking for edit.php link associated with '$firststring' entry");
$pos3 = strpos($html, '"', $pos2);
$editlink = substr($html,$pos2,$pos3-$pos2);
$editlink = str_replace("&amp;","&",$editlink);
line_out("Retrieving ".$editlink."...");

$crawler = $client->request('GET', $editlink);
$html = $crawler->html();
markTestPassed("Retrieved $editlink");
showHTML("Show retrieved page",$html);

line_out('Looking for the form with a value="Save" submit button');
$form = webauto_get_form_button($crawler,'Save');
$firststring='42986856712';
webauto_change_form($form, $firststringfield, $firststring);
$crawler = $client->submit($form);
markTestPassed("edit.php submitted");
$html = $crawler->html();
checkPostRedirect($client);
showHTML("Show retrieved page",$html);

line_out("Checking edit results");
if ( strpos(strtolower($html), $firststring) !== false ) {
    markTestPassed("edit.php results verified");
} else {
    error_out("Record did not seem to be updated");
    return;
}

// Delete...
line_out("Looking for delete.php link in index.php associated with '$firststring' entry");
$pos = strpos($html, $firststring);
$pos2 = strpos($html, "delete.php", $pos);
$pos3 = strpos($html, '"', $pos2);
if ( $pos < 1 || $pos2 < 1 || $pos3 < 1 ) {
    error_out("Could not find delete.php link");
    return;
}
$editlink = substr($html,$pos2,$pos3-$pos2);
$editlink = str_replace("&amp;","&",$editlink);
line_out("Retrieving ".$editlink."...");

$crawler = $client->request('GET', $editlink);
$html = $crawler->html();
markTestPassed("Retrieved delete.php");
showHTML("Show retrieved page",$html);

// Do the Delete
line_out('Looking for the form with a value="Delete" submit button');
$form = webauto_get_form_button($crawler,'Delete');
$crawler = $client->submit($form);
markTestPassed("Submitted form on delete.php");
$html = $crawler->html();
checkPostRedirect($client);
showHTML("Show retrieved page",$html);

line_out("Making sure '$firststring' has been deleted");
if ( strpos($html,$firststring) > 0 ) {
    error_out("Entry '$firststring' not deleted");
    return;
} else {
    markTestPassed("Entry '$firststring' deleted");
}

line_out("Cleaning up old records...");
$i = 5;
while ( $i-- > 0 ) {
    $pos2 = strpos($html, "delete.php");
    if ( $pos2 < 1 ) break;
    $pos3 = strpos($html, '"', $pos2);
    if ( $pos3 < 1 ) break;
    $editlink = substr($html,$pos2,$pos3-$pos2);
    $editlink = str_replace("&amp;","&",$editlink);
    line_out("Retrieving ".$editlink."...");

    $crawler = $client->request('GET', $editlink);
    $html = $crawler->html();
    showHTML("Show retrieved page",$html);

    // Do the Delete
    line_out('Looking for the form with a value="Delete" submit button');
    $form = webauto_get_form_button($crawler,'Delete');
    $crawler = $client->submit($form);
    checkPostRedirect($client);
    $html = $crawler->html();
    showHTML("Show retrieved page",$html);

    $passed--;  // Undo post redirect
}


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
    return;
}

// There is a maximum 25 passes for this test
$perfect = 25;
$score = webauto_compute_effective_score($perfect, $passed, $penalty);

if ( $score < 1.0 ) autoToggle();

if ( ! $titlefound ) {
    error_out("These pages do not have proper titles so this grade is not official");
    return;
}

if ( $score > 0.0 ) webauto_test_passed($score, $url);
