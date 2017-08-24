<?php

require_once "../config.php";
require_once "webauto.php";
use Goutte\Client;

line_out("Grading PHP-Intro Rock Paper Scissors");
?>
<p>The specification for this assignment is:
<a href="http://www.wa4e.com/assn/rps/" target="_blank">http://www.wa4e.com/assn/rps/</a></p>
<p>If you need to run this grading program on an application that is running on your
laptop or desktop computer with a URL like <strong>http://localhost...</strong> you
will need to install and use the <a href="http://www.wa4e.com/md/" target="_blank">NGrok or LocalTunnel</a>
application to get a temporary Internet-accessible URL that can be used with this application.
</p>
<?php

$grade = 0;
$passed = 0;
$title_once = false; // Only send the error once
$titlefound = false;
$account = "umsi@umich.edu";

$url = getUrl('http://www.wa4e.com/solutions/rps/index.php');
if ( $url === false ) return;

error_log("RPS ".$url);

line_out("Initial page ".htmlent_utf8($url)."...");
flush();

// http://symfony.com/doc/current/components/dom_crawler.html
$client = new Client();
$client->setMaxRedirects(5);

try {
$crawler = $client->request('GET', $url);
$html = $crawler->html();
showHTML("Show retrieved page",$html);

$retval = webauto_check_title($crawler);
if ( $retval === true ) {
    $titlefound = true;
} else {
    $titlefound  = false;
    error_out($retval);
}

line_out("Looking for  an anchor tag with text of 'Please Log In' (case matters)");
$link = $crawler->selectLink('Please Log In')->link();
$url = $link->getURI();
line_out("Retrieving ".htmlent_utf8($url)."...");
$crawler = $client->request('GET', $url);
markTestPassed('login.php page retrieved');
$html = $crawler->html();
showHTML("Show retrieved page",$html);

$retval = webauto_check_title($crawler);
if ( $retval === true ) {
    $titlefound = true;
} else {
    $titlefound  = false;
    error_out($retval);
}

// Doing a log in
line_out('Looking for the form with a value="Log In" submit button');
$form = webauto_get_form_button($crawler,'Log In');
line_out("-- this autograder expects the log in form field names to be:");
line_out("-- who and pass");
line_out("-- if your fields do not match these, the next tests will fail.");



line_out("Attempting a bad login $account pass=meow123.");
$form->setValues(array("who" => $account, "pass" => "meow123"));
$crawler = $client->submit($form);
markTestPassed('Submit bad login values to login.php');
// This one does not post redirect
// checkPostRedirect($client);
$html = $crawler->html();
showHTML("Show retrieved page",$html);

$retval = webauto_check_title($crawler);
if ( $retval === true ) {
    $titlefound = true;
} else {
    $titlefound  = false;
    error_out($retval);
}

line_out("Searching for 'Incorrect password'");
if ( stripos($html,'Incorrect password') > 0 ) {
    markTestPassed('Incorrect password handled correctly');
} else {
    error_out("Could not find 'Incorrect password'"); 
}

line_out("Attempting a good login.");
$form->setValues(array("who" => $account, "pass" => "php123"));
$crawler = $client->submit($form);
markTestPassed('Submit good login values to login.php');
checkPostRedirect($client);
$html = $crawler->html();
showHTML("Show retrieved page",$html);

try {
    $form = $crawler->selectButton('Play')->form();
    markTestPassed('Login success - at game.php');
    
} catch(Exception $ex) {
    error_out("Did not find form with a 'Play' button");
}

$names = array('Rock', 'Paper', 'Scissors');

function check($matches) {
    $map = Array('Rock' => 0, 'Paper' => 1, 'Scissors' => 2) ;
    $me = $map[$matches[1]];
    $co = $map[$matches[2]];
    $result = $matches[3];
    $re=2;
    if ( stripos($result,"Win") !== false ) $re=0;
    if ( stripos($result,"Lose") !== false ) $re=1;

    if ( $me == $co && $re == 2 ) return true;
    if ( ( ($co + 1 ) % 3) == $me && $re == 0 ) return true;
    if ( ( ($me + 1 ) % 3) == $co && $re == 1 ) return true;
    return false;
}

for ( $i=0; $i<5; $i++) {
    try {
        $form = $crawler->selectButton('Play')->form();
    } catch(Exception $ex) {
        error_out("Did not find form with a 'Play' button");
        break;
    }
    $form['human'] = $i % 3; // Set the drop-down
    line_out("Playing ".$names[$i % 3]);
    $crawler = $client->submit($form);
    $html = $crawler->html();
    showHTML('Show retrieved page',$html);

    $retval = webauto_check_title($crawler);
    if ( $retval === true ) {
        $titlefound = true;
    } else {
        if ( ! $title_once ) error_out($retval);
        $title_once = true;
    }

    line_out("Making sure login name (".$account.") is in the markup");
    if ( stripos($html, $account) > 0 ) {
        markTestPassed("Found login name in game.php markup");
    } else {
        error_out("Login name is missing in game.php markup");
    }

    $matches = Array();
    preg_match('/Your Play=([^ ]*) Computer Play=([^ ]*) Result=(.*)/',$html,$matches);
    if ( count($matches) != 4 ) {
        error_out('Could not find line starting with "Your Play=" (case matters)');
        continue;
    }
    line_out('Found:'.$matches[0]);
    if ( check($matches) ) {
        success_out('Correct play');
        $passed++;
    } else {
        error_out('Incorrect play');
    }
}

} catch (Exception $ex) {
    error_out("The autograder did not find something it was looking for in your HTML - test ended.");
    error_out("Usually the problem is in one of the pages returned from your application.");
    error_out("Use the 'Toggle' links above to see the pages returned by your application.");
    error_log($ex->getMessage());
    error_log($ex->getTraceAsString());
    $detail = "This indicates the source code line where the test stopped.\n" .
        "It may not make any sense without looking at the source code for the test.\n".
        'Caught exception: '.$ex->getMessage()."\n".$ex->getTraceAsString()."\n";
    showHTML("Internal error detail.",$detail);
}

$perfect = 17;
$score = webauto_compute_effective_score($perfect, $passed, $penalty);

if ( $score < 1.0 ) autoToggle();

if ( ! $titlefound ) {
    error_out("These pages do not have proper titles so this grade was not sent");
    return;
}

if ( $score > 0.0 ) webauto_test_passed($score, $url);

