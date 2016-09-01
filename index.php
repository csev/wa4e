<?php
use \Tsugi\Core\LTIX;
use \Tsugi\UI\Output;

require_once "top.php";
require_once "nav.php";
?>
<div id="container">
<h1>Web Applications for Everybody (WA4E)</h1>
<?php if ( isset($_SESSION['id']) ) { ?>
<p>
Welcome to our Massive Open Online Course (MOOC). Now that you have logged in, you have access to 
course-style features of this web site.
<ul class="list-group">
<li class="list-group-item">
As you go through the <a href="tsugi/lessons.php">Lessons</a> in the course you now will see additional
links to the autograders in the class.  You can attempt the autograders and get a score.</li>
<li class="list-group-item">
You can track your progress through the course using the <a href="tsugi/assignments.php">Assignments</a>
tool and when you complete a group of assignments, you can earn a <a href="tsugi/badges.php">Badge</a>.
You can download these badges and host them on your web site or refer the badge URLs on this site.</li>
<li class="list-group-item">
There is an 
<a href="https://disqus.com/home/channel/webapplicationsforeverybody/" target="_blank">online disucsson forum</a>
hosted by Disqus.</li>
<li class="list-group-item">
If you want to use these Creative Commons Licensed materials in your own classes you can download
or link to the artifacts, 
<a href="tsugi/cc/export.php">export the course material</a> as an 
<a href="https://www.imsglobal.org/cc/index.html" target="_blank">
IMS Common Cartridge®</a>, or apply for 
an <a href="tsugi/admin/key/index.php">IMS LTI key and secret</a> to launch the autograders from your LMS.
</li>
</ul>
<?php } else { ?>
<p>
Hello and welcome to my <b>"Web Applications for Everybody"</b> site where you can work through my materials 
and learn PHP, MySQL, JQuery, and Handlebars.
</p>
<p>
You can use this web site many different ways:
<ul class="list-group">
<li class="list-group-item">
You browse my videos and course materials under <a href="tsugi/lessons.php">Lessons</a>.  The materials
I have developed
for this class are all provided with a Creative Commons license so you can download or link to 
them to incorporate them into your own teaching if you like.</li>
<li class="list-group-item">
This site uses <a href="http://www.tsugi.org" target="_blank">Tsugi</a> framework to embed a learning 
management system into this site.  So if you <a href="tsugi/login.php">log in</a> to this site 
it is as if you have joined a free, global
open and online course.  You have a grade book, autograded assignments, a discussion forum, and can earn
badges for your efforts.</li>
<li class="list-group-item">
This site supports the <a href="https://www.imsglobal.org/cc/index.html" target="_blank">
IMS Common Cartridge® Specification</a> that allows you to extract all of the material from the course
and import it into a Learning Management system like 
<a href="http://www.sakaiproject.org" target="_blank">Sakai</a>, Moodle, Canvas, Blackboard, BrightSpace, or others.
You can download a cartridge using the <a href="tsugi/cc/export.php">export feature</a>.  You will also need
an <a href="tsugi/admin/key/index.php">IMS LTI key and secret</a> to launch the autograders from your LMS.
</li>
<li class="list-group-item">
The code for this site including the autograders, slides, and course content is all available on
<a href="https://github.com/csev/php-intro" target="_blank">GitHub</a>.  That means you could make your own
copy of the course site, publish it and remix it any way you like.  Even more exciting, you could translate
the entire site (course) into your own language and publish it.</li>
</ul>
<?php } ?>
I think that this is an exciting way to provide online materials.  If you are interested in collaborating
to build these kinds of sites for yourself, please see the 
<a href="http://www.tsugi.org" target="_blank">tsugi.org</a> website.
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
<h3>Copyright</h3>
<p>
All this material produced by Charles Severance (including audio and video) 
is Copyright Creative Commons Attribution 3.0 
unless otherwise indicated.  
</p>
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
