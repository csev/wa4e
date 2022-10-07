<!DOCTYPE html>
<html>
<body>
<h1>Array Functions</h1>
<h2><a href="https://www.php.net/manual/en/function.array-key-exists"></a>array-key-exists</h2>
<?php
$search_array = array('first' => 1, 'second' => 4, 'third'=>null);
if (array_key_exists('first', $search_array)) {
    echo "The 'first' element is in the array";
    echo "Does the 'third' element exist: ";
    var_dump( isset($search_array['third']));
    reset($search_array);
    var_dump(array_key_exists('third', $search_array));
    reset($search_array);
    echo count($search_array);
    echo "<br>";
   echo reset($search_array);
   echo is_array($search_array);
    reset($search_array);
    echo print_r($search_array);
    echo "<br>";
   echo sort($search_array);
   echo print_r($search_array);
   echo "<br>";
    reset($search_array);
    echo ksort($search_array);
    reset($search_array);
    echo print_r($search_array);
    echo "<br>";
   echo asort($search_array);
    reset($search_array);
    echo print_r($search_array);
    echo "<br>";
   echo print_r($search_array);
   echo "<br>";
    echo shuffle($search_array);
    reset($search_array);
    echo print_r($search_array);
    echo "<br>";
    sort($search_array);
   echo  print_r($search_array);
   echo "<br>";
    echo ksort($search_array);
    echo print_r($search_array);
    echo "<br>";
    echo asort($search_array);
    echo print_r($search_array);
    echo "<br>";
    shuffle($search_array);
    echo print_r($search_array);
    echo "<br>";
  }
?>

</body>
</html>
