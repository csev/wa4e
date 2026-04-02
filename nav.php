<?php
require_once('buildmenu.php');

$set = buildMenu();
$CFG->defaultmenu = $set;

$OUTPUT->bodyStart();
// Set the topNav for the session
$OUTPUT->topNavSession($set);

$OUTPUT->topNav();
$OUTPUT->flashMessages();
