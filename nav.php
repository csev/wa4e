<?php
require_once('buildmenu.php');

$set = buildMenu();

$OUTPUT->bodyStart();
// Set the topNav for the session
$OUTPUT->topNavSession($set);

$OUTPUT->topNav();
$OUTPUT->flashMessages();
