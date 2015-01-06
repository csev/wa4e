<!DOCTYPE html>
<html>
<head>
<title>Don't look at the source to this code</title>
</head>
<body>
<h1>Getting started with a database</h1>
<p>
Before we take the next step we need a database and a table
and some data in a table.
<pre>
<?php
$host = $_SERVER['HTTP_HOST'];
if ( $host == "localhost:8888" ) { ?>
You appear to be running MAMP
<?php } else if ( true ) { ?>

<?php } else { ?>

<?php } 

//var_dump($_SERVER);
?>
</pre>
<p>Next: <a href="index7.htm">index7.htm</a></p>
</body>
</html>
