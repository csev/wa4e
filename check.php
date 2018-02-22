<?php

// This does a lot of sanity checking and leads the admin through
// the install process

if ( isset($CFG) ) return;  // Do not allow indirect calls

define('COOKIE_SESSION', true);
if ( ! file_exists('tsugi') ) {
    echo('<p style="color:red">'."\n");
    echo("This site needs Tsugi to function, please check out and configure\n");
    echo("a copy of Tsugi as a subfolder:\n");
    echo("<pre>\n");
    echo("    cd ".__DIR__."\n");
    echo("    git clone https://github.com/tsugiproject/tsugi\n");
    echo("</pre>\n");
    echo("</p>\n");
    die();
}

if ( ! file_exists('tsugi/config.php') ) {
    echo('<p style="color:red">'."\n");
    echo("You have not yet configured your instance of Tsugi.
          </p><p>
          Please copy tsugi/config-dist.php to tsugi/config.php and edit 
          config.php according to the installation instructions.
          See http://www.tsugi.org/ for complete installation instructions.
          </p><p>
          Since you are embedding Tsugi into this web site, 
          make sure to set several *additional* configuration parameters:\n");
    echo("<pre>\n");
    echo("On a production server:\n");
    echo('    $apphome = \'https://www.wa4e.com\';   // For the site'."\n");
    echo('    $wwwroot = \'https://www.wa4e.com/tsugi\';   // For Tsugi'."\n");
    echo("     ...\n");
    echo("\nor on localhost:\n");
    echo('    $apphome = \'http://localhost:8888/wa4e\';   // For the site'."\n");
    echo('    $wwwroot = \'http://localhost:8888/wa4e/tsugi\';   // For Tsugi'."\n");
    echo("     ...\n");
    echo("\nand to scan for tools and install modules at the parent level:\n");
    echo('    $CFG->tool_folders = array("admin", "../tools", "../mod");'."\n");
    echo('    $CFG->install_folder = $CFG->dirroot."/../mod";'."\n");
    echo("\nSet the name of the 'course' the site is hosting and\n");
    echo("point to the lessons.json file:\n\n");
    echo('    $CFG->context_title = "Web Applications for Everybody";'."\n");
    echo('    $CFG->lessons = $CFG->dirroot."/../lessons.json";'."\n");
    echo("\nMake sure to configure all the values indicated for 'Embedded Tsugi' in the config.php.\n");
    echo("</pre>\n");
    echo("</p>\n");
    die();
}

require_once("tsugi/config.php");

require_once("tsugi/admin/sanity.php");

