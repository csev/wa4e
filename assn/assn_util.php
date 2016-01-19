<?php

function pointsDetail($assn_json) {
    $r = "The total number of points for this assignment is $assn_json->totalpoints.\n";
    if ( isset($assn_json->instructorpoints) && $assn_json->instructorpoints > 0 ) {
        $r .= "You will get up to $assn_json->instructorpoints points from your instructor.\n";
    }   
    if ( isset($assn_json->peerpoints) && $assn_json->peerpoints > 0 ) {
        $r .= "You will get up to $assn_json->peerpoints points from your peers.\n";
    }   
    if ( isset($assn_json->assesspoints) && $assn_json->assesspoints > 0 ) {
        $r .= "You will get $assn_json->assesspoints for each peer assignment you assess.\n";
    }
    if ( isset($assn_json->minassess) && $assn_json->minassess > 0 ) {
        $r .= "You need to grade a minimum of $assn_json->minassess peer assignments.\n";
    }
    if ( isset($assn_json->maxassess) && $assn_json->maxassess >  $assn_json->minassess) {
        $r .= "You can grade up to $assn_json->maxassess peer assignments if you like.\n";
    }
    return $r;
}

function loadPeer($file) {
    $string = file_get_contents($file);
    $json = json_decode($string);
    if ( $json === null ) {
        echo("<pre>\n");
        echo("Invalid JSON:\n\n");
        echo($string);
        echo("</pre>\n");
        die("<p>Internal error contact instructor</p>\n");
    }
    return $json;
}
