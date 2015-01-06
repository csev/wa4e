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
<p>Next: <a href="index4.htm">index4.htm</a></p>
</body>
</html>
