<?php
//Output "Have a good day!" if the current time (HOUR) is less than 20:
$t = date("H");

if ($t < "20") {
  echo "Have a good day!";
echo "<br>";

  //Output "Have a good morning!" if the current time is less than 10, and "Have a good day!" if the current time is less than 20. Otherwise it will output "Have a good night!":
$t2 = date("H")+10;
if ($t2 < "10") {
  echo "Have a good morning!";
} elseif ($t2 < "20") {
  echo "Have a good day!";
} else {
  echo "Have a good night!";
}

}

echo "<br><br>";
$favcolor = "red";

switch ($favcolor) {
  case "red":
    echo "Your favorite color is red!";
    break;
  case "blue":
    echo "Your favorite color is blue!";
    break;
  case "green":
    echo "Your favorite color is green!";
    break;
  default:
    echo "Your favorite color is neither red, blue, nor green!";
}
echo "<br><br>";
$x = 1;

while($x <= 5) {
  echo "The number is: $x <br>";
  $x++;
}

echo "<br><br>";
$fuel = 10;

while($fuel >1) {
  echo "vroom \n";
  $fuel = $fuel-1;
}

echo "<br><br>";
$count2 =0;
do {
    echo "$count2 times 5 is " .$count2 * 5;
    echo "<br>";
} while (++$count2 <=5);

echo "<br><br>";
for ($count3=1; $count3 <=6; $count3++) {
    echo "$count3 times 6 is " .$count3*6;
    echo "<br>";
}

?>