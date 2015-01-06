<!DOCTYPE html>
<html>
<head>
<title>Request / Response Cycle</title>
</head>
<body>
<h1>Hello World - index3.php</h1>
<p>
The PHP code segments share variables.  All of the 
&lt?php ... ?> sequences are part of one program.
This is a <a href="http://www.php-intro.com">PHP</a> 
page. Most of it is just HTML.
</p>
<pre> 

<?php
 $x = 5;
 print "x is ".$x;
?>

Back in HTML - lets go into PHP one more time.

<?php $x = $x + 1; print "x is ".$x; ?>

Note that in between &lt?php ... ?> newlines 
and whitespace are not significant.
</pre>
</body>
</html>
