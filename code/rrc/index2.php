<!DOCTYPE html>
<html>
<head>
<title>Request / Response Cycle</title>
</head>
<body>
<h1>Hello World - index2.php</h1>
<p>
This is a <a href="http://www.php-intro.com">PHP</a> 
page. Most of it is just HTML.
</p>
<pre> 
But in a PHP file, we can switch into PHP by
enclosing PHP code between &lt;?php and ?>.
As the searcer reads the PHP file, when it
sees PHP code, it is run on the server and
The output of that code is returned to 
your browser in place of the &lt;?php ... ?>

<?php
 print "Hello world";
?>

Back in HTML - lets go into PHP one more time.

<?php
 print "Today is:". date("Y-m-d H:i:s");
?>

All done...
</pre>
<p>Next: <a href="index3.php">index3.php</a></p>
</body>
</html>
