<?php

$folder = basename(__DIR__);

// Reference can be relative
$reference = "../../solutions/$folder";

// These two must be absolute as they will be in peer.json
$reference_implementation = "http://www.wa4e.com/solutions/$folder";
$specification = "http://www.wa4e.com/assn/$folder";

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

