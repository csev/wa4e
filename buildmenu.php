<?php

function buildMenu() {
    global $CFG;
    $R = $CFG->apphome . '/';
    $T = $CFG->wwwroot . '/';
    $adminmenu = isset($_COOKIE['adminmenu']) && $_COOKIE['adminmenu'] == "true";
    $set = new \Tsugi\UI\MenuSet();
    $set->setHome($CFG->servicename, $CFG->apphome);
    if ( isset($CFG->lessons) ) {
        $set->addLeft('Lessons', $R.'lessons');
        if ( isset($CFG->tdiscus) && $CFG->tdiscus  ) $set->addLeft('Discussions', $R.'discussions');
    }
    // $set->addLeft('YouTube', 'https://www.youtube.com/playlist?list=PLlRFEj9H3Oj7FHbnXWviqQt0sKEK_hdKX');
    if ( isset($_SESSION['id']) ) {
    	$set->addLeft('Assignments', $R.'assignments');
    } else {
        $set->addLeft('Materials', $R.'materials');
    }

    if ( isset($_SESSION['id']) ) {
        $submenu = new \Tsugi\UI\Menu();
        $submenu->addLink('Profile', $R.'profile');
        if ( isset($CFG->google_map_api_key) ) {
            $submenu->addLink('Map', $R.'map');
        }
        $submenu->addLink('Badges', $R.'badges');
        $submenu->addLink('Materials', $R.'materials');
        $submenu->addLink('Rate this course', 'https://www.class-central.com/mooc/7362/web-applications-for-everybody');
        $submenu->addLink('Privacy', $R.'privacy');
        if ( $CFG->providekeys ) {
            $submenu->addLink('LMS Integration', $T . 'settings');
        }
        if ( isset($CFG->google_classroom_secret) ) {
            $submenu->addLink('Google Classroom', $T.'gclass/login');
        }
        $submenu->addLink('Free App Store', 'https://www.tsugicloud.org');
        if ( $CFG->DEVELOPER ) {
            $submenu->addLink('Test LTI Tools', $T . 'dev');
        }
        if ( isset($_COOKIE['adminmenu']) && $_COOKIE['adminmenu'] == "true" ) {
            $submenu->addLink('Administer', $T . 'admin/');
        }
        $submenu->addLink('Logout', $R.'logout');
        if ( isset($_SESSION['avatar']) ) {
            $set->addRight('<img src="'.$_SESSION['avatar'].'" title="'.htmlentities(__('User Profile Menu - Includes logout')).'" style="height: 2em;"/>', $submenu);
            // htmlentities($_SESSION['displayname']), $submenu);
        } else {
            $set->addRight(htmlentities($_SESSION['displayname']), $submenu);
        }
    } else {
        $set->addRight('Login', $T.'login.php');
    }

    $set->addRight('Book', 'http://milneopentextbooks.org/the-missing-link-an-introduction-to-web-development-and-programming/');
    $set->addRight('Instructor', 'http://www.dr-chuck.com');

    return $set;
}

