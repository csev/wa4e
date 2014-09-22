<?php

class Person {
    public $fullname = false;
    public $givenname = false;
    public $familyname = false;
    public $room = false;

    function get_name() {
        if ( $this->fullname !== false ) return $this->fullname;
        if ( $this->familyname != false && $this->givenname != false ) {
            return $this->givenname . ' ' . $this->familyname;
        }
        return false;
    }
}

$chuck = new Person();
$chuck->fullname = "Chuck Severance";
$chuck->room = "3437NQ";

$colleen = new Person();
$colleen->familyname = 'van Lent'; 
$colleen->givenname = 'Colleen';
$colleen->room = '3439NQ';

print $chuck->get_name() . "\n";
print $colleen->get_name() . "\n";
