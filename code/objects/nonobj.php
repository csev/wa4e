<?php

$chuck = array("fullname" => "Chuck Severance", 'room' => '3437NQ');
$colleen = array("familyname" => "van Lent", 
	'givenname' => 'Colleen', 'room' => '3439NQ');

function get_person_name($person) {
	if ( isset($person['fullname']) ) return $person['fullname'];
	if ( isset($person['familyname']) && isset($person['givenname']) ){
		return $person['givenname'] . ' ' . $person['familyname'] ;
	}
	return false;
}

print get_person_name($chuck) . "\n";
print get_person_name($colleen) . "\n";
