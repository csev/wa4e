<!DOCTYPE html>
<html>
<body>

<?php

echo "In PHP, division forces operands to be floating point and 
expsession values by operators silently and aggressively:<br> <br> ";

$a =56; $b=12;
$c =$a/$b;

echo " For the expression <br> \$a =56; <br> \$b=12;<br> 
\$c =\$a/\$b"."<br><br>  " ."c: $c\n";

echo "<br><br>";

echo "<br><p>For the expression 100_string + 36.25 +TRUE;</p><br>";
$d = "100" + 36.25 +TRUE;
echo " d: $d \n";

echo "<br><p>For the expression \$e =(int) 9.9 -1;</p><br>";

$e =(int) 9.9 -1;
echo "e: $e\n";

echo "<p>For the expression \$f =sam + 25;</p>";

echo " Fatal error: Uncaught TypeError: Unsupported operand types: string + int in C:\wamp64\www\tests\oct22\casting.php on line 28"; 

echo "<br><p>For the expression \$f =sam . 25;</p>";
$g = "sam" . 25;
echo"g: $g\n";
?>

</body>
</html> 