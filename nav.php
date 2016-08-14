<?php
$OUTPUT->bodyStart();
$R = $CFG->apphome . '/';
$set = new \Tsugi\UI\MenuSet();
$set->setHome($CFG->servicename, $CFG->apphome);
$set->addRight('Instructor', 'http://www.dr-chuck.com');
$set->addRight('Install', $R.'install.php');
$set->addRight('Book', 'http://textbooks.opensuny.org/the-missing-link-an-introduction-to-web-development-and-programming/');
$OUTPUT->topNav($set);
$OUTPUT->flashMessages();
