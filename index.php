<?php
use \Tsugi\Core\LTIX;
use \Tsugi\UI\Output;

require_once "top.php";
require_once "nav.php";
?>
<div id="container">
<h1>Web Applications for Everybody (WA4E)</h1>
<p>
Hello and welcome to my <b>"Web Applications for Everybody"</b> site where you can work through my materials 
and learn PHP, MySQL, JQuery, and Handlebars.
</p>
<p>
You can submit homework to the autograders for this site if 
you are logged in.
I would love to hear from you if you find this material useful.  
</p>
<h3>TextBook</h3>
<p>
I am using an open textbook 
<a href="http://textbooks.opensuny.org/the-missing-link-an-introduction-to-web-development-and-programming/"
target="_new">
The Missing Link: An Introduction to Web Development and Programming
</a>
written by Michael Mendez 
and published by 
<a href="http://textbooks.opensuny.org/" target="_blank">OpenSUNY</a>.  All of the electronic copies
of the book are free.   Print copies of the book are available on 
<a href="http://www.amazon.com/The-Missing-Link-Introduction-Development/dp/1502447967/"
target="_blank">Amazon</a>.
</p>
<p>
Video lectures can be found on my
<a href="https://www.youtube.com/playlist?list=PLlRFEj9H3Oj5F-GFxG-rKzORVAu3jestu" target="_blank">
PHP/MySql YouTube Channel</a> and
you can also listen to the audio recordings of the live lectures for 
<a href="https://archive.org/details/201509UMSI664Podcasts" target="_blank">UMSI 664 Fall 2015</a>
on campus.
</p>
<h3>Copyright</h3>
<p>
All this material produced by Charles Severance (including audio and video) 
is Copyright Creative Commons Attribution 3.0 
unless otherwise indicated.  
</p>
<h3>Technology Notes</h3>
<p>
For this course I prepare slides in PowerPoint, record audio using a
<a href="http://www.sandisk.com/products/sansa-music-and-video-players/sandisk-sansa-clip-zip-mp3-player" target="_blank">Sansa Clip</a>, use iTunes to convert the audio to MP3, use
Camtasia for my screencasts, 
and use 
<a href="http://www.parallels.com/" target="_blank">Parallels</a> to run Windows.
</p>
<p>
This material is always in progress and is revised everytime I teach the course.   
You can see all of the material and its history on 
<a href="https://github.com/csev/php-intro" target="_blank">GitHub</a>.
<p>
-- Dr. Chuck
</p>
<!--
<?php
echo(Output::safe_var_dump($_SESSION));
var_dump($USER);
?>
-->
</div>
<?php $OUTPUT->footer();
