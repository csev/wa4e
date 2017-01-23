<?php
require_once "../config.php";

use \Tsugi\Core\Settings;
use \Tsugi\Core\LTIX;
use \Tsugi\UI\SettingsForm;

require_once "html_util.php";

$LTI = LTIX::requireData();
$p = $CFG->dbprefix;

if ( SettingsForm::handleSettingsPost() ) {
    header( 'Location: '.addSession('index.php') ) ;
    return;
}

// All the assignments we support
$assignments = array(
    'a01.php' => 'HTML Validate',
    'colleen.php' => 'Colleen HTML Assignment 01'
);

$oldsettings = Settings::linkGetAll();

$assn = Settings::linkGet('exercise');

// Get any due date information
$dueDate = SettingsForm::getDueDate();

// Deal with the POST
if ( isset($_FILES['html_01']) ) {
    $retval = checkHTMLPost();
    if ( $retval === true ) {
        header( 'Location: '.addSession('index.php') ) ;
        return;
    }
    if ( is_string($retval) ) {
         $_SESSION['error'] = $retval;
        header( 'Location: '.addSession('index.php') ) ;
        return;
    }
}

// View
$OUTPUT->header();
echo "<style> 
span{color:red;
font-size:16px;}
.correct{
color:green;
font-size:16px;
font-weight:bold;
};
</style>";
$OUTPUT->bodyStart();

// Settings button and dialog

echo('<span style="position: fixed; right: 10px; top: 5px;">');
if ( $USER->instructor ) {
    echo('<a href="grades.php" target="_blank"><button class="btn btn-info">Grade detail</button></a> '."\n");
}
SettingsForm::button();
echo('</span>');

SettingsForm::start();
SettingsForm::select("exercise", __('Please select an assignment'),$assignments);
SettingsForm::dueDate();
SettingsForm::end();

$OUTPUT->flashMessages();

$OUTPUT->welcomeUserCourse();

$ALL_GOOD = false;

function my_error_handler($errno , $errstr, $errfile, $errline , $trace = false)
{
    global $OUTPUT, $ALL_GOOD;
    error_out("The autograder experienced some kind of error - test ended.");
    $message = $errfile."@".$errline." ".$errstr;
    error_log($message);
    if ( $trace ) error_log($trace);
    $detail = 'Caught exception: '.$message."\n".$trace."\n";
    $OUTPUT->togglePre("Internal error detail.",$detail);
    $OUTPUT->footer();
    $ALL_GOOD = true;
}

function fatalHandler() {
    global $ALL_GOOD, $OUTPUT;
    if ( $ALL_GOOD ) return;
    $error = error_get_last();
    error_out("Fatal error handler triggered");
    if($error) {
        my_error_handler($error["type"], $error["message"], $error["file"], $error["line"]);
    } else {
        $OUTPUT->footer();
    }
    exit();
}
register_shutdown_function("fatalHandler");

// Assume try / catch is in the script
if ( strlen($assn) < 1 || ! isset($assignments[$assn]) ) {
    if ( $USER->instructor ) {
        echo("<p>Please use settings to select an assignment for this tool.</p>\n");
    } else {
        echo("<p>This tool needs to be configured - please see your instructor.</p>\n");
    }
    $OUTPUT->footer();
    return;
}


$oldgrade = $RESULT->grade;

if ( $LINK->grade > 0 ) {
    echo('<p class="alert alert-info">Your current grade on this assignment is: '.($LINK->grade*100.0).'%</p>'."\n");
}

if ( $dueDate->message ) {
    echo('<p style="color:red;">'.$dueDate->message.'</p>'."\n");
}
?>
<p>
<form name="myform" enctype="multipart/form-data" method="post" action="<?= addSession('index.php') ?>">
Please upload your file containing the HTML.
<p><input name="html_01" type="file"></p>
<input type="submit">
</form>
</p>
<?php

if ( ! isset($_SESSION['html_data']) ) {
    $OUTPUT->footer();
    return;
}

$grade = 0;
$possgrade = 0;
$data = $_SESSION['html_data'];
unset($_SESSION['html_data']);
echo("<pre>\n");
// echo("Input HTML\n");
// echo(htmlentities($data));
// echo("\n");

$valid= validateHTML($data);

if (! $valid){
    echo "Your code did not validate.  Please return to the W3 validator at validator.w3.org to check your code.";
    $OUTPUT->footer();
    return;
}

require($assn);

echo ($grade .' out of ' . $possgrade ."\n\n");
echo ("\n\nYour score is  " . $grade/$possgrade . "\n\n");

$gradetosend = $grade/$possgrade;
$scorestr = "Your answer is correct, score saved.";

if ( $oldgrade > $gradetosend ) {
    $scorestr = "New score of $gradetosend is < than previous grade of $oldgrade, previous grade kept";
    $gradetosend = $oldgrade;
}

// Use LTIX to send the grade back to the LMS.
$debug_log = array();
$retval = LTIX::gradeSend($gradetosend, false, $debug_log);

if ( $retval === true ) {
    echo($scorestr."\n\n");
} else if ( is_string($retval) ) {
    echo("Grade not sent: ".$retval."\n\n");
} else {
    echo("<pre>\n");
    var_dump($retval);
    echo("</pre>\n");
}

$ALL_GOOD = true;

$OUTPUT->footer();


