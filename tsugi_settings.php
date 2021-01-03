<?php

$CFG->context_title = "Web Applications for Everybody";
$CFG->ownername = "WA4E";
$CFG->servicename = "WA4E";
$CFG->owneremail = "drchuck@learnxp.com";

$CFG->launcherror = $CFG->apphome . "/launcherror";

$CFG->providekeys=true;
$CFG->autoapprovekeys='/.+@.+\\.edu/';

$CFG->expire_pii_days = 150;  // Three months
$CFG->expire_user_days = 400;  // One year
$CFG->expire_context_days = 600; // 1.5 Years
$CFG->expire_tenant_days = 800; // Two years

$CFG->lessons = $CFG->dirroot.'/../lessons.json';

$CFG->tdiscus = $CFG->apphome . '/mod/tdiscus/';

$buildmenu = $CFG->dirroot.'/../buildmenu.php';
if ( file_exists($buildmenu) ) {
    require_once $buildmenu;
    $CFG->defaultmenu = buildMenu();
}


