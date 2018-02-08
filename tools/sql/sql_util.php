<?php

use \Tsugi\Util\Mersenne_Twister;

require_once "names.php";
require_once "courses.php";

function makeRoster($code,$course_count=false,$name_count=false) {
    global $names, $courses;
    $MT = new Mersenne_Twister($code);
    $retval = array();
    $cc = 0;
    foreach($courses as $k => $course) {
    $cc = $cc + 1;
    if ( $course_count && $cc > $course_count ) break;
        $new = $MT->shuffle($names);
        $new = array_slice($new,0,$MT->getNext(17,53));
        $inst = 1;
        $nc = 0;
        foreach($new as $k2 => $name) {
            $nc = $nc + 1;
            if ( $name_count && $nc > $name_count ) break;
            $retval[] = array($name, $course, $inst);
            $inst = 0;
        }
    }
    return $retval;
}


// Load the export to JSON format from MySQL
function load_mysql_json_export($data) {

    // The format changes for the php JSON EXPORT plugins...

    // This version and earlier - the whole thing is not valid JSON
    // Export to JSON plugin for PHPMyAdmin @version 4.6.5.2

    // This version and later it is valid JSON but quite different
    // {"type":"header","version":"4.7.2","comment":"Export to JSON plugin for PHPMyAdmin"},

    $pos = 0;
    $tables = array();
    $retval = array();
    $errors = array();


    // echo("<pre>\n");
    try {
        $newformat = json_decode($data, true);
    } catch(Exception $e) {
        $newformat = null;
    }
    if ( $newformat !== null ) {
        foreach($newformat as $table) {
            if ( $table['type'] != "table" ) continue;
            $name = strtolower($table['name']);
            $retval[$name] = $table['data'];
            // echo("Name $name\n"); var_dump($table['data']); die('new format');
        }
    } else {
        $things = explode('//',$data);
        // echo("<pre>\n"); print_r($things);
        foreach($things as $thing) {
            $startpos = strpos($thing,'[{');
            $endpos = strpos($thing,'}]');
            if ( $startpos === false || $endpos === false ) {
                continue;
            }
            $thing = trim($thing);
            $pieces = explode("\n",$thing);
            // echo("==========\n"); print_r($pieces);
            if ( count($pieces) < 1 ) continue;
            $name = trim($pieces[0]);
            $chunks = explode('.',$name);
            if ( count($chunks) > 1 ) {
                $name = $chunks[count($chunks)-1];
            }
            $name = strtolower($name);
            // echo("name=$name\n");

            $json_str = substr($thing, $startpos-1, 2+$endpos-$startpos);
            // echo("json_str=$json_str\n");
            $json = json_decode($json_str, true);
            if ( $json === NULL ) {
                $errors[] = "Unable to parse the $name JSON ".json_last_error();
                continue;
            }

            // echo("Name $name\n"); var_dump($json);
            $retval[$name] = $json;
        }
    }

    // Actually prepare the data for return
    foreach($retval as $name => $json ) {
        if ( count($json) < 1 ) continue;

        $key = strtolower($name).'_id';
        if ( !isset($json[0][$key]) ) continue;

        $table = array();
        foreach($json as $row) {
            if ( isset($row[$key]) && is_numeric($row[$key]) ) {
                $table[$row[$key]+0] = $row;
            }
        }
        $retval[$name."_table"] = $table;
    }

    // echo("<pre>\n"); echo("=== retval ===\n"); print_r($retval); echo("</pre>\n"); die('retval');
    return $retval;
}
