<?php

class PartyAnimal {
	function __construct() {
		echo("Constructed\n");
    }
    function something() {
		echo("Something\n");
	}
	function __destruct() {
		echo("Destructed\n");
    }
}

echo("--One\n");
$x = new PartyAnimal();
echo("--Two\n");
$y = new PartyAnimal();
echo("--Three\n");
$x->something();
echo("--The End?\n");

