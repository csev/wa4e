<?php
require_once("../assn_util.php");
$json = loadPeer("peer.json");
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
<li>Your name must be in the &lt;title&gt; tag like 'Charles Severance PHP'</li>
<li>There should be an &lt;h1&gt; tag with your name and text like 'Charles Severance PHP'</li>
<li>You should use a &lt;pre&gt; tag to create ASCII art of the first letter of your 
name four spaces in from the left margin</li>
<li>Your code should use PHP to compute the SHA256 of <b>your name</b> and print it 
out like the sample application.  You must compute this in your index.php file.  
The PHP code to achieve this for 'Charles Severance' is: 
<pre> 
print hash('sha256', 'Charles Severance'); 
</pre> </li>
<!--
<li>Your name must be in a JavaScript alert() box with text like 
'Charles Severance in an alert box' </li>
<li>Your name must be in the console log with text like 'Charles Severance in the log' </li></li>
-->
<li>Open <a href="fail.txt" target="_blank">this file</a> 
and copy-paste its contents into a file named <b>fail.php</b> in the 
same folder as your <b>index.php</b>.  Do not alter this file - do <b>not</b> fix 
the mistake in the code 
in this file.  The goal is to trigger an error to verify that 
we see errors in the browser.</li>
<li>Open <a href="check.txt" target="_blank">this file</a> 
and copy-paste in the contents into a file named <b>check.php</b> in the 
same folder as your <b>index.php</b>. 
</li>
</ul>
You must run these files in your PHP server.  Make a folder under your
<strong>DOCUMENT_ROOT</strong> and then make sure your files are in that file.
Sample DOCUMENT_ROOT values for some servers:
<pre>
DOCUMENT_ROOT: c:\xampp\htdocs
DOCUMENT_ROOT: /Applications/MAMP/htdocs
</pre>
You can check the DOCUMENT_ROOT value for your server by scrolling 
down in your PHPInfo output.  You may have changed a setting in your PHP 
server to move the DOCUMENT_ROOT and that is OK as well.
</p>
<p>
Just make sure all the files are in a folder somewhere within
DOCUMENT_ROOT and that all your testing uses <b>localhost</b> URLs
like:
<pre>
http://localhost:8888/php-intro/php/index.php
</pre>
If you turn in screen shots with <b>file://</b> in the URL you will 
get zero points for the assignment.
</p>
<?php if ( isset($json->solution) ) { ?>
<h2>Sample solution</h2>
<p>
You can explore a sample solution for this problem at
<pre>
<a href="<?= $json->solution ?>" target="_blank"><?= $json->solution ?></a>
</pre>
<?php } ?>
<h2>Resources</h2>
<p>There are several sources of information so you can do the assignment:
<ul>
<li>Lectures and materials on <i>Introduction to Dynamic Web Content</i> from
<a href="http://www.wa4e.com" target="_blank">www.wa4e.com</a></li>
<li>The Wikipedia page on 
<a href="https://en.wikipedia.org/wiki/Hypertext_Transfer_Protocol" target="_blank">
HTTP - Hypertext Transport Protocol</a>
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
<p>
<?= pointsDetail($json) ?>
</p>
<h2>Sample Screen Shots</h2>
<p>
<center>
<a href="01-index.png" target="_blank">
<img src="01-index.png" width="80%"></a>
</center>
</p>
<p>
<center>
<a href="03-fail.png" target="_blank">
<img src="03-fail.png" width="80%"></a>
</center>
</p>
<p>
<center>
<a href="04-check.png" target="_blank">
<img src="04-check.png" width="80%"></a>
</center>
</p>
<hr/>
<p>
Provided by: <a href="http://www.wa4e.com/" target="_blank">
www.wa4e.com</a> <br/>
</p>
<center>
Copyright Creative Commons Attribution 3.0 - Charles R. Severance
</center>
</body>
</html>
