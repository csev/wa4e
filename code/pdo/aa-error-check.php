<?php

echo "<pre>\n";
echo "Checking some configuration file options...\n\n";
echo 'display_errors = ' . ini_get('display_errors') . "\n";

$good = 0;
if ( ini_get('display_errors') == 1 ) {
    echo("display_errors is set correctly...\n\n");
    $good ++;
} else {
    echo("WARNING: You need to edit your configuration file\n");
    echo("and set:\n\n");
    echo("display_errors = On\n\n");
}

if ( $good == 1 ) {
    echo("</pre>\n");
    return;
}

echo("YOUR CONFIGURATION FILE IS IN BAD SHAPE!!!!!!\n");
echo("You need to edit this file:\n\n");
echo(php_ini_loaded_file()."\n\n");
echo("Fix the issues identified above\n");
echo("Until you do this, you will be very unhappy doing PHP development\n");
echo("in this PHP environment.\n");

echo "</pre>\n";

