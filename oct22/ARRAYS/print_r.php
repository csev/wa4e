<!DOCTYPE html>
<html>
<body>
<h1>print_r</h1>

<h2> PHP dumping</h2>

<h3>Example 1:</h3>
<pre><?php

$a = array ('a' => 'apple', 'b' => 'banana', 'c' => array ('x', 'y', 'z'));
print_r ($a);

?></pre>


<h3>Example 2:</h3>
<p><?php
$a2 = array ('a' => 'apple', 'b' => 'banana', 'c' => array ('x', 'y', 'z'));
var_dump($a2);

?></p>
<h3>Example 3:</h3>
<p><?php
$print_false =FALSE;
echo "How to print false";
var_dump($print_false);

?></p>



</body>
</html>
