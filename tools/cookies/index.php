<?php
require_once "../config.php";

use \Tsugi\Core\LTIX;
use \Tsugi\UI\Lessons;

$LAUNCH = LTIX::requireData();
$p = $CFG->dbprefix;

// Note - cannot have any output before setcookie
$code = md5($USER->id+$LINK->id+$CONTEXT->id);
if ( ! isset($_COOKIE['zap']) ) {
    setcookie('wa4e_secret_cookie', $code, time()+3600);
}

$oldgrade = $RESULT->grade;

if ( isset($_POST['cookie']) && isset($_POST['session']) ) {
    $_SESSION['post_data'] = $_POST;
    $error = '';
    $score = 0;
    if ( $_POST['cookie'] == $code ) {
        $score += 0.5;
    } else {
        $error = 'Incorrect cookie value';
    }
    if ( $_POST['session'] == session_id() || 
         ( isset($_COOKIE[session_name()]) && 
         $_POST['session'] == $_COOKIE[session_name()] ) ) {
        $score += 0.5;
    } else {
        if ( strlen($error) > 0 ) $error .= ' / ';
        $error .= 'Incorrect session ID value';
    }

    $RESULT->gradeSend($score);
    if ( $scoer >= 1.0 ) {
        $_SESSION['success'] = 'Assignment completed';
    } else {
        $_SESSION['error'] = $error . ' Score=' . $score;
    }
    
    header('Location: '.addSession('index.php'));
    return;
}

// View
$OUTPUT->header();
$OUTPUT->bodyStart();
$OUTPUT->topNav();
$OUTPUT->flashMessages();

?>
<p>
<b>Finding Cookies and Sessions in a Haystack</b>
</p>
<?

if ( $USER->displayname === false || $USER->displayname == '' ) {
    echo('<p style="color:blue;">Auto grader launched without a student name.</p>'.PHP_EOL);
} else {
    $OUTPUT->welcomeUserCourse();
}
if ( $RESULT->grade > 0 ) {
    echo('<p class="alert alert-info">Your current grade on this assignment is: '.($RESULT->grade*100.0).'%</p>'."\n");
}

$oldcookie = '';
$oldsession = '';
if ( isset($_SESSION['post_data']) ) {
    if ( isset($_SESSION['post_data']['cookie']) ) $oldcookie = $_SESSION['post_data']['cookie'];
    if ( isset($_SESSION['post_data']['session']) ) $oldsession = $_SESSION['post_data']['session'];
}
unset($_SESSION['post_data']);

?>
<p>
This application has stored a cookie named <b>wa4e_secret_cookie</b>
in your browser.  You must find the value of that cookie and enter it 
on this form.
</p>
<p>
You must also figure out your session identifier.   It is either
a GET parameter or a cookie value named <b><?= session_name() ?></b>.
If you have both a GET parameter and a Cookie, then either session ID
will work for this assignment.
</p>
<p>
This assignment is best completed using "Developer Mode" of your
browser.
</p>
<p>
Enter your values in each of the fields below and press "Submit".
<form method="post">
<p>
<label for="cookie">Enter Cookie Value: </label>
<input type="text" id="cookie" name="cookie" size="40"
value="<?= htmlentities($oldcookie) ?>"/></p>
<p>
<label for="cookie">Enter SessionID:</label>
<input type="text" id="session" name="session" size="40"
value="<?= htmlentities($oldsession) ?>"/></p>
<input type="submit">
</form>
</p>
<?php
if ( $USER->instructor ) {
echo("\n<hr/>");
echo("\n<pre>\n");
print_r($_COOKIE);
echo("\n");
echo("\n</pre>\n");
}
$OUTPUT->footer();


