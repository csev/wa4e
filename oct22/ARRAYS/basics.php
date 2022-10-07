<!DOCTYPE html>
<html>
<body>
<p>create_array</p>
<?php

$va = array();
$va[]="Hello";
$va[]="World";
print_r($va);

$va = array();
$va["str"]="Hello";
$va["lang"]="eng";
$va["str"]="Bonjour";
$va["lang"]="fr";
$va["str"]="Hola";
$va["lang"]="sp";
print_r($va);

?>


<p>multidim_array</p>
<?php
$cars = array (
  array("Volvo",22,18),
  array("BMW",15,13),
  array("Saab",5,2),
  array("Land Rover",17,15)
);
    
for ($row = 0; $row < 4; $row++) {
  echo "<p><b>Row number $row</b></p>";
  echo "<ul>";
  for ($col = 0; $col < 3; $col++) {
    echo "<li>".$cars[$row][$col]."</li>";
  }
  echo "</ul>";
}

?>


<p>array_assoc_loop</p>
<?php

$age = array("Peter"=>"35", "Ben"=>"37", "Joe"=>"43");

var_dump($age);
echo "<br>";

foreach($age as $x => $x_value) {
  echo "Key=" . $x . ", Value=" . $x_value;
  echo "<br>";
  echo ("<pre>\n");
  echo ("\n</pre>\n");

}

?>
<p>create</p>

</body>
</html>