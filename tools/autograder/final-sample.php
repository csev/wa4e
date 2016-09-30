<?php

$folder = basename(__FILE__, ".php");

// Reference can be relative
$reference = "http://www.wa4e.com/solutions/$folder";

// These two must be absolute as they will be in peer.json
$reference_implementation = "http://www.wa4e.com/solutions/$folder";
$specification = "http://www.wa4e.com/assn/$folder";

$assignment_type = "Sample Exam";
$assignment_type_lower = "exam";

$title_singular = 'Pizza Store';
$title_plural = 'Pizza Stores';
$table_name = 'pizza';
$table_name_lower = 'pizza';

$fields = array(
    array('Store', 'store', false),
    array('Address', 'address', false),
    array('Rating', 'rating', 'i',false,10),
    array('Best Pizza', 'best', false)
);

require_once("crud.php");
