<?php
use \Tsugi\Util\Net;
use \Tsugi\Core\LTIX;
use \Tsugi\UI\Output;

// Help the installer through the setup process 
require "check.php" ; 

require "top.php";
require "nav.php";

?>
<div id="container">
<div style="margin-left: 10px; float:right">
<iframe width="400" height="225" src="https://www.youtube.com/embed/tuXySrvw8TE?rel=0" frameborder="0" allowfullscreen></iframe>
</div>
<h1>Web Applications for Everybody</h1>
<?php if ( isset($_SESSION['id']) ) { ?>
<p>
Welcome to our Massive Open Online Course (MOOC). Now that you have logged in, you have access to 
course-style features of this web site.
<ul>
<li>
As you go through the <a href="lessons">Lessons</a> in the course you now will see additional
links to the autograders in the class.  You can attempt the autograders and get a score.</li>
<li>
You can track your progress through the course using the <a href="tsugi/assignments.php">Assignments</a>
tool and when you complete a group of assignments, you can earn a <a href="badges">Badge</a>.
You can download these badges and host them on your web site or refer the badge URLs on this site.</li>
<li>
You can use these Creative Commons Licensed materials 
such as the 
<a href="lectures" target="_blank">lectures</a>
in your own classes.
You can also 
<a href="tsugi/cc/">export the course material</a> as an
IMS Common Cartridge®, or apply for
an IMS Learning Tools Interoperability® (LTI®)
<a href="tsugi/admin/key/index.php">key and secret</a> 
 to launch the autograders from your LMS.
</li>
</ul>
<?php } else { ?>
<p>
Hello and welcome to my site where you can learn to build database-backed
web sites using PHP, MySQL, JQuery, and Handlebars. 
You can take this course and receive a certificate at:
<ul>
<li><a href="https://www.coursera.org/specializations/web-applications" target="_blank">Coursera: Web Applications for Everybody Specialization</a> </li>
<li><a href="https://www.youtube.com/watch?v=xr6uZDRTna0" target="_blank">FreeCodeCamp: Web Applications for Everybody</a>
<li><a href="https://online.umich.edu/series/web-applications-for-everybody/" target="_blank">Free certificates for University of Michigan students and staff</a></li>
</ul>
If you <a href="tsugi/login.php">log in</a> to this site
you have joined a free, global
open and online course.  You have a grade book, autograded assignments, discussion forums, and can earn
badges for your efforts.</p>
<p>
We take your privacy seriously on this site, you can review our
<a href="privacy">Privacy Policy</a> for more details.
</p>
<p>
If you want to use these materials
in your own classes you can download or link to the artifacts on this site,
<a href="tsugi/cc/">export the course material</a> as an
IMS Common Cartridge®, or apply for
an IMS Learning Tools Interoperability® (LTI®)
<a href="tsugi/admin/key/index.php">key and secret</a>
 to launch the autograders from your LMS.
</p>
<p>
The code for this site including the autograders, slides, and course content is all available on
<a href="https://github.com/csev/wa4e" target="_blank">GitHub</a>.  That means you could make your own
copy of the course site, publish it and remix it any way you like.  Even more exciting, you could translate
the entire site (course) into your own language and publish it.  
</p>
<?php } ?>
This site uses <a href="http://www.tsugi.org" target="_blank">Tsugi</a> 
framework to embed a learning 
management system into this site and handle the autograders.  
If you are interested in collaborating
to build these kinds of sites for yourself, please see the 
<a href="http://www.tsugi.org" target="_blank">tsugi.org</a> website.
</p>
<h3>TextBook</h3>
<p>
I am using an open textbook 
<a href="http://milneopentextbooks.org/the-missing-link-an-introduction-to-web-development-and-programming/"
target="_new">
The Missing Link: An Introduction to Web Development and Programming
</a>
written by Michael Mendez 
and published by 
<a href="http://milneopentextbooks.org/" target="_blank">OpenSUNY</a>.  All of the electronic copies
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
echo("IP Address: ".Net::getIP()."\n");
echo(Output::safe_var_dump($_SESSION));
var_dump($USER);
?>
-->
</div>
<?php 
require "foot.php";
