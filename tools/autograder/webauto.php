<?php
\Tsugi\Core\LTIX::getConnection();

use \Tsugi\Grades\GradeUtil;

// A library for webscraping graders
require_once "vendor/autoload.php";

use \Tsugi\UI\SettingsForm;
use \Tsugi\Core\LTIX;
use \Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;

$ngrok_fails = array(
    "ERR_NGROK_",
    "Before you can serve HTML content, you must sign up for an ngrok account and install your authtoken",
    "ngrok.com/signup",
    "Sign up for an ngrok account",
    "ngrok account and install your authtoken",
);

// Get any due date information
$dueDate = SettingsForm::getDueDate();
$penalty = $dueDate->penalty;

if ( $dueDate->message ) {
    echo('<p style="color:red;">'.$dueDate->message.'</p>'."\n");
}

function webauto_setup() {
    global $client;
    // http://symfony.com/doc/current/components/dom_crawler.html
    // $client = new Client();
    // $client->getClient()->setSslVerification(false);

    // https://stackoverflow.com/questions/63539346/how-can-i-fix-the-ssl-problem-in-symfony-goutte
    $client = new Client(HttpClient::create(['verify_peer' => false, 'verify_host' => false]));
    $client->setMaxRedirects(5);
}


/* Returns a crawler */
function webauto_load_url($url, $message=false) {
    global $client;
    global $ngrok_fails;
    global $base_url_path;
    global $webauto_http_status;
    global $webauto_http_content;
    line_out(" ");
    if ( $message ) echo("<b>".htmlentities($message)."</b><br/>\n");
    echo("<hr/><b>Loading URL:</b> ".htmlentities($url));
    $the_url = str_replace('"',"&quot;", $url);
    if ( strpos($the_url, '/') === 0 ) $the_url = $base_url_path . $the_url;
    echo(' (<a href="'.$the_url.'" target="_blank">Open URL</a>)');
    echo("<br/>\n");
    flush();
    try {
        $crawler = $client->request('GET', $url);
        $response = $client->getResponse();
        $webauto_http_status = $response->getStatusCode();
        $webauto_http_content = $response->getContent();

        // Check for ngrok failures
        $ngrok_fail = false;
        foreach($ngrok_fails as $fail) {
            if ( stripos($webauto_http_content, $fail) !== false ) $ngrok_fail = true;
        }
        if ( $ngrok_fail ) {
            error_out("It appears that your ngrok tunnel is not working properly: ".$webauto_http_content);
        }
    } catch(\Exception $e) {
        error_out($e->getMessage());
        return false;
    }
    return $crawler;
}


function webauto_get_html($crawler) {
    global $ngrok_fails, $client;
    try {
        $html = $crawler->html();
    }
    catch (Exception $e) {
        $response = $client->getResponse();
        $status = $response->getStatus();
        error_out("Could not find HTML ".$e->getMessage());
        error_log("Could not find HTML ".$e->getMessage());
        throw new Exception("Could not retrieve HTML from page");
    }
    // Check for ngrok failures
    $ngrok_fail = false;
    foreach($ngrok_fails as $fail) {
        if ( stripos($html, $fail) !== false ) $ngrok_fail = true;
    }
    if ( $ngrok_fail ) {
        error_out("It appears that your ngrok tunnel is not working properly.");
    }
    showHTML("Show retrieved page",$html);

    // https://stackoverflow.com/questions/1084741/regexp-to-strip-html-comments
    $html = preg_replace('/<!--(.*)-->/Uis', '', $html);
    return $html;
}

function showHTML($message, $html) {
    global $OUTPUT;
    $pos = strpos($html,'<b>Fatal error</b>');
    if ( $pos === false ) {
        $OUTPUT->togglePre($message, $html);
        return;
    }
    echo('<p style="color:red">Your application seems to have an error in this page:</p>');
    echo("\n<pre>\n");
    echo(htmlentities($html));
    echo("\n</pre>\n");
    
}

function titleNote() {
    global $USER, $LINK, $CONTEXT;
    $check = substr(md5($USER->id+$LINK->id+$CONTEXT->id),0,8);
?>
<p>
To receive a grade for this assignment, include your name
<?php
if ( $USER->displayname ) {
    echo("(<strong>".htmlentities($USER->displayname)."</strong>) and/or \n");
} else {
    echo("and \n");
}
echo("this string <strong>".$check."</strong> \n");
?>
in the &lt;title&gt; tag in all the pages of your application.
</p>
<p>If you need to run this grading program on an application that is running on your
laptop or desktop computer with a URL like <strong>http://localhost...</strong> you
will need to install and use the <a href="http://www.wa4e.com/md/" target="_blank">NGrok</a>
application to get a temporary Internet-accessible URL that can be used with this application.
</p>
<?php
}

function getUrl($sample) {
    global $USER, $access_code;

    if ( isset($access_code) && $access_code ) {
        if ( isset($_GET['code']) ) {
            if ( $_GET['code'] != $access_code ) {
                die('Bad access code');
            }
        } else {
            echo('<form>Please enter the access code:
            <input type="text" name="code"><br/>
            <input type="submit" class="btn btn-primary" value="Access">
            </form>');
            return false;
        }
    }

    if ( isset($_GET['url']) ) {
        echo('<p><a href="#" onclick="window.location.href = window.location.href; return false;">Re-run this test</a></p>'."\n");
        if ( isset($_SESSION['lti']) ) {
            $retval = GradeUtil::gradeUpdateJson(array("url" => $_GET['url']));
        }
        return $_GET['url'];
    }

    echo('<form>');
    echo('<input type="hidden" name="'.session_name().'" value="'.session_id().'">');
    echo('    Please enter the URL of your web site to grade:<br/>
        <input type="text" name="url" value="'.$sample.'" size="100"><br/>');
    if ( isset($_GET['code']) ) {
        echo('<input type="hidden" name="code" value="'.$_GET['code'].'"><br/>'); 
    }
    echo('<input type="submit" class="btn btn-primary" value="Evaluate">
        </form>');
    if ( $USER->displayname ) {
        echo("By entering a URL in this field and submitting it for
        grading, you are representing that this is your own work.  Do not submit someone else's
        web site for grading.
        ");
    }

    echo("<p>You can run this autograder as many times as you like and the last submitted
    grade will be recorded.  Make sure to double-check the course Gradebook to verify
    that your grade has been sent.</p>\n");
    return false;
}

function checkPostRedirect($client) {
    global $passed;
    line_out("Checking to see if the POST redirected to a GET");
    $method = $client->getRequest()->getMethod();
    if ( strcasecmp($method,"get") == 0 ) {
        $passed++;
        markTestPassed("POST Redirect Check");
    } else {
        error_out('Expecting POST to Redirected to a GET - found '.$method);
    }
}

function markTestPassed($message=false) {
    global $passed;
    if ( $message ) {
        success_out("Test passed: ".$message);
    } else {
        success_out("Test passed.");
    }
    $passed++;
}

function webauto_test_passed($grade, $url) {
    global $USER, $OUTPUT;

    success_out("Test complete");

    if ( ! isset($_SESSION['lti']) ) {
        line_out('Not setup to return a grade..');
        return false;
    }

    if ( $USER->instructor ) {
        line_out('Instructor grades are not sent..');
        return false;
    }

    $LTI = $_SESSION['lti'];

    $old_grade = isset($LTI['grade']) ? $LTI['grade'] : 0.0;

    if ( $grade < $old_grade ) {
        line_out('New grade is not higher than your previous grade='.$old_grade);
        line_out('Sending your previous high score');
        $grade = $old_grade;
    }

    GradeUtil::gradeUpdateJson(json_encode(array("url" => $url)));
    $debug_log = array();
    $retval = LTIX::gradeSend($grade, false, $debug_log);
    $OUTPUT->dumpDebugArray($debug_log);
    $success = false;
    if ( $retval == true ) {
        $success = "Grade sent to server (".$grade.")";
    } else if ( is_string($retval) ) {
        $failure = "Grade not sent: ".$retval;
    } else {
        echo("<pre>\n");
        var_dump($retval);
        echo("</pre>\n");
        $failure = "Internal error";
    }

    if ( strlen($success) > 0 ) {
        success_out($success);
        error_log($success);
    } else if ( strlen($failure) > 0 ) {
        error_out($failure);
        error_log($failure);
    } else {
        error_log("No status");
    }

    return true;
}

function autoToggle() {
    global $div_id;
    echo("<script>dataToggle('$div_id');</script>\n");
    $div_id--;
    echo("<script>dataToggle('$div_id');</script>\n");
}

function webauto_check_title($crawler) {
    global $USER, $LINK, $CONTEXT;
    $check = substr(md5($USER->id+$LINK->id+$CONTEXT->id),0,8);

    try {
        $title = $crawler->filter('title')->text();
    } catch(Exception $ex) {
        return "Did not find title tag";
    }

    if ( stripos($title,$check) !== false ) {
        return true;
    }
    if ( $USER->displayname && strlen($USER->displayname) > 0 ) {
        if ( stripos($title, $USER->displayname) !== false ) return true;
    }

    return "Did not find name or '$check' in title tag";
}

function webauto_compute_effective_score($perfect, $passed, $penalty) {
    $score = $passed * (1.0 / $perfect);
    if ( $score < 0 ) $score = 0;
    if ( $score > 1 ) $score = 1;
    if ( $passed > $perfect ) $passed = $perfect;
    if ( $penalty == 0 ) {
        $scorestr = "Score = $score ($passed/$perfect)";
    } else {
        $scorestr = "Raw Score = $score ($passed/$perfect) ";
        $score = $score * (1.0 - $penalty);
        $scorestr .= "Effective Score = $score after ".$penalty*100.0." percent late penalty";
    }
    line_out($scorestr);
    return $score;
}

function webauto_check_post_redirect($client) {
    global $passed;
    line_out("Checking to see if there was a POST redirect to a GET");
    $method = $client->getRequest()->getMethod();
    if ( $method == "get" ) {
        $passed++;
    } else {
        error_out('Expecting POST to Redirect to GET - found '.$method);
    }
}

function webauto_get_form_button($crawler,$text) 
{
    try {
        $form = $crawler->selectButton($text)->form();
        markTestPassed('Found form with "'.$text.'" button');
        return $form;
    } catch(Exception $ex) {
        $msg = 'Did not find form with a "'.$text.'" button';
        error_out($msg);
        throw new Exception($msg);
    }
}

// http://api.symfony.com/4.0/Symfony/Component/DomCrawler/Form.html
function webauto_change_form($form, $name, $value) 
{
    try {
        $x = $form->get($name);
    } catch(Exception $ex) {
        $msg = 'Did not find form field named "'.$name;
        error_out($msg);
        throw new Exception($msg);
    }
    line_out("Changing form field '$name' to be $value");
    $x->setValue($value);
}

function webauto_search_for_many($html, $needles) 
{
    $retval = true;
    foreach($needles as $needle ) {
        $check = webauto_search_for($html,$needle.'');
        $retval = $retval && $check;
    }
    return $retval;
}

function webauto_search_for($html, $needle)
{
    if ( stripos($html,$needle) > 0 ) {
        markTestPassed("Found '$needle'");
        return true;
    } else {
        error_out("Could not find '$needle'");
        return false;
    }
}

function webauto_dont_want($html, $needle)
{
    if ( stripos($html,$needle) > 0 ) {
        error_out("Found something that should not be there: '$needle'");
        return true;
    } else {
        markTestPassed("Did not find '$needle'");
        return false;
    }
}
