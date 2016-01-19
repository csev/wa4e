<?php
$string = file_get_contents("peer.json");
$json = json_decode($string);
if ( $json === null ) {
    echo("<pre>\n");
    echo("Invalid JSON:\n\n");
    echo($string);
    echo("</pre>\n");
    die("<p>Internal error contact instructor</p>\n");
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Assignment: <?= $json->title ?></title>
<style>
li { padding: 5px; }
</style>
</head>
<body style="margin-left:5%; margin-bottom: 60px; margin-right: 5%; font-family: sans-serif;">
<h1>Assignment: <?= $json->title ?></h1>
<p>
<?= $json->description ?>
</p>
<p>
<ul>
<li>Your name must be in the title bar like 'Charles Severance Request/Response'</li>
<li>There should be an &lt;h1&gt; tag with your name and text like 'Charles Severance Request/Response'</li>
<li>You should use a &lt;pre&gt; tag to create ASCII art of the first letter of your 
name four spaces in from the left margin</li>
<li>Your code should use PHP to compute the SHA256 of your name and print it 
out like the sample application.  You must compute this in PHP.  The PHP code 
to achieve this for 'Charles Severance' is: 
<pre> 
print hash('sha256', 'Charles Severance'); 
</pre> </li>
<li>Your name must be in a JavaScript alert() box with text like 
'Charles Severance in an alert box' </li>
<li>Your name must be in the console log with text like 'Charles Severance in the log' </li></li>
</ul>
</p>
<?php if ( isset($json->solution) ) { ?>
<h2>Sample solution</h2>
<p>
You can see with a sample solution for this problem at
<pre>
<a href="<?= $json->solution ?>" target="_blank"><?= $json->solution ?></a>
</pre>
<?php } ?>
<h2>Resources</h2>
<p>There are several sources of information so you can do the assignment:
<ul>
<li>Lectures and materials on <i>Introduction to Dynamic Web Content</i> from
<a href="http://www.php-intro.com" target="_blank">www.php-intro.com</a></li>
<li> Chapters 23, 24, 25, and 26 from the free textbook
<a href="http://textbooks.opensuny.org/the-missing-link-an-introduction-to-web-development-and-programming/"
target="_blank">The Missing Link: An Introduction to Web Development and Programming</a> written by
<a href="http://textbooks.opensuny.org/author/mmendez/" target="_blank">Michael Menendez</a>
and published by
<a href="http://textbooks.opensuny.org/the-missing-link-an-introduction-to-web-development-and-programming/" 
target="_blank">Open SUNY Textbooks</a>.
</ul>
</p>
<h1>What To Hand In</h1>
<p>
For this assignment you will hand in:
<ol>
<?php
foreach($json->parts as $part ) {
    echo("<li>$part->title</li>\n");
}
?>
</ol>
</p>
<h2>Grading</h2>
<p>
<?= $json->grading ?>
</p>
<h2>Sample Screen Shots</h2>
<p>
<center>
<a href="01-alert.png" target="_blank">
<img src="01-alert.png" width="80%"></a>
</center>
</p>
<p>
<center>
<a href="02-console.png" target="_blank">
<img src="02-console.png" width="80%"></a>
</center>
</p>
<p>
Provided by: <a href="http://www.php-intro.com/" target="_blank">
www.php-intro.com</a> <br/>
</p>
<center>
Copyright Creative Commons Attribution 3.0 - Charles R. Severance
</center>
</body>
</html>
