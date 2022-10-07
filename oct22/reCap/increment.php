<!DOCTYPE html>
<html>
<body>

<?php
$x = 10;  
$y = 6;

echo "$x + $y ";
//bad code
$z = $y + $x++; 
echo "x is now $x \n";
echo "and z is $z \n";

$z = $y + $x++;
echo "x is now $x \n";
echo "and z is $z \n";


?>  

</body>
</html>