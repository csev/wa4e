<?php
require_once "../config.php";
\Tsugi\Core\LTIX::getConnection();

use \Tsugi\Util\U;
use \Tsugi\Grades\GradeUtil;

session_start();

// Get the user's grade data also checks session
$user_id = U::get($_REQUEST, 'user_id');
if ( ! $user_id ) die('user_id required');
$row = GradeUtil::gradeLoad($user_id);

$menu = new \Tsugi\UI\MenuSet();
$menu->addLeft(__('Back to all grades'), 'index.php');

// View
$OUTPUT->header();
$OUTPUT->bodyStart();
$OUTPUT->topNav($menu);
$OUTPUT->flashMessages();

// Show the basic info for this user
GradeUtil::gradeShowInfo($row, false);

if ( isset($row['note']) ) {
    echo("<p>Note:</p>\n<pre>\n");
    echo(htmlentities($row['note']));
    echo("</pre>\n");
}

if ( U::strlen($row['json']) > 0 ) {
    echo("<p>JSON:</p>\n<pre>\n");
    echo(htmlentities($row['json']));
    echo("</pre>\n");
}

$OUTPUT->footer();
