<?php

$folder = basename(__DIR__);

// Reference can be relative
$reference = "../../solutions/$folder";

// These two mucst be absolute as theu will be in peer.json
$reference_implementation = "http://www.php-intro.com/solutions/$folder";
$specification = "http://www.php-intro.com/assn/$folder";

$assignment_type = "Assignment";
$assignment_type_lower = "assignment";

$title_singular = 'Automobile';
$title_plural = 'Automobiles';
$table_name = 'autos';
$table_name_lower = 'autos';

$fields = array(
    array('Make', 'make', false),
    array('Model', 'model', false),
    array('Year', 'year', 'i',false,10),
    array('Mileage', 'mileage', 'i',false,10)
);

