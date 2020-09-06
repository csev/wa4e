<!DOCTYPE html>
<?php
require_once("../assn_util.php");
$json = loadPeer("peer.json");
?>
<html>
<head>
<title>Assignment: <?= $json->title ?></title>
</head>
<body style="margin-left:5%; margin-bottom: 60px; margin-right: 5%; font-family: sans-serif;">
<h1>Assignment: <?= $json->title ?></h1>
<p>
<?= $json->description ?>
<p>
You will transform from this:
<center>
<a href="01-No-style.png" target="_blank">
<img src="01-No-style.png" width="80%" border="2px"></a>
</center>
To this:
<center>
<a href="02-style.png" target="_blank">
<img src="02-style.png" width="80%" border="2px"></a>
</center>
Using only CSS.
</p>
<h1>Resources</h1>
<p>There are several sources of information so you can do the assignment:
<ul>
<li>Lectures and materials on <i>Cascading Style Sheets</i> from
<a href="https://www.wa4e.com/lessons/css" target="_blank">www.wa4e.com</a></li>
</ul>
</p>
<h1>Pre-Requisites</h1>
<p>
<ul>
<li><p>Please install the <a href="http://chrispederick.com/work/web-developer/" target="_blank">
Web Developer Toolkit</a> for your browser from Chris Pedrick and know how to use it to 
disable CSS styles.</p></li>
</ul>
</p>
<h1>Tasks</h1>
<p>
Here are the tasks for this assignment.  You can do all the editing for this assignment
in a folder on your computer.
<ul>
<li><p>Take this <a href="index.txt" target="_blank">this file</a> and 
copy/paste the contents into 
<b>index.htm</b>.  You will not change this file.
<li><p>Take <a href="blocks.txt" target="_blank">this file</a>
and copy/paste the contents into 
<b>blocks.css</b> in the same folder as the above file.
</p>
<li><p>Edit the <b>blocks.css</b> and add the CSS rules so 
it the HTML file looks like the above image when you view the index.htm
file in your browser.
</p></li>
<li><p>The four boxes have five pixel borders with different colors and five pixels 
of margin and padding.  It is probably simplest to use fixed positioning to get the
boxes to be "sticky" to the corners of the screen even when you resize.  Make the boxes
width be <b>25%</b> so the width changes as you resize your browser.</p></li>
<li><p>Center the link at the top of the page.  Use your developer console / inspect element
feature of your browser to visit <a href="https://www.brainyquote.com/" target="_blank">
https://www.brainyquote.com/</a> and figure out the background color, font, and text color
they are using an replicate that exactly for the link in your <b>index.htm</b>.
</p></li>
<li><p>Your CSS must pass the validator at:
<pre>
<a href="https://jigsaw.w3.org/css-validator" target="_blank">https://jigsaw.w3.org/css-validator</a>
</pre>
</p></li>
</ul>
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


<h1>Sample Screen Shots</h1>
<p>
Using inspect element on the 
<a href="https://www.brainyquote.com/" target="_blank">
https://www.brainyquote.com/</a>.
<center>
<a href="04-brainy-inspect.png" target="_blank">
<img src="04-brainy-inspect.png" width="80%" border="2px"></a>
</center>
</p>
<p>
Looking at 
<a href="https://www.brainyquote.com/" target="_blank">
https://www.brainyquote.com/</a> using Chris Pedrick's
Web Developer add on to turn off all styles:
<center>
<a href="05-brainy-no-css.png" target="_blank">
<img src="05-brainy-no-css.png" width="80%" border="2px"></a>
</center>
</p>
<p>Passing the CSS validator:
<p>
<center>
<a href="06-css-validator.png" target="_blank">
<img src="06-css-validator.png" width="80%" border="2px"></a>
</center>
</p>


<p style="padding-top:30px;">
Provided by: <a href="http://www.wa4e.com/" target="_blank">
www.wa4e.com</a> <br/>
</p>
<center>
Copyright Creative Commons Attribution 3.0 - Charles R. Severance
</center>
</body>
</html>
