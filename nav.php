<div id="header">
<h1><a href="index.php" class="selected" accesskey="1">PHP and MySQL</a></h1>
<?php
   function navto($arg)
   {
	echo ('href="' . $arg . '"');
   	if ( strpos($_SERVER["REQUEST_URI"], $arg) )  echo ' class="selected" ';
   }
   ?>
<ul class="toolbar">
<li><a <? navto("install.php") ?> >Install</a></li>
<li><a href="http://textbooks.opensuny.org/the-missing-link-an-introduction-to-web-development-and-programming/"
target="_blank">Book</a></li>
<li><a href=http://www.dr-chuck.com/ target=_new>Instructor</a></li>
<!-- <li><a <? navto("about.php") ?> >About</a></li> -->
</ul>
</div>
