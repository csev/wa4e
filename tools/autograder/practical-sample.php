<?php

// After editing this file with the new values, copy this file 
// to the tools/autograder folder in the main repo.

// Make sure to name the file in tools/autograder the same as the 
// folder here in solutions.

//    cp fields.php [path]/tools/autograder/practical-sample.php

// Edit index.php in tools/autograder to add the entry to this file

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

// What is the name of this assignment...
$folder = basename(__DIR__);
if ( $folder == 'autograder') {
    $folder = basename(__FILE__, ".php");
}

// Reference can be relative for testing
$reference = "http://www.wa4e.com/solutions/$folder";

// These two must be absolute as they will be in peer.json
$reference_implementation = "http://www.wa4e.com/solutions/$folder";
$specification = "http://www.wa4e.com/assn/$folder";

// In the solutions folder this is empty
require_once "crud.php";
