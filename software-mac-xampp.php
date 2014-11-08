<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php include("header.php"); ?>
</head>
<body style="margin: 10px">
<div id="main">
<h3>
Setting up the XAMPP PHP/MySql Environment on a Macintosh
</h3>
<p>We will install the XAMPP bundled PHP/MySql system.  Installing the XAMPP
(or similar) bundle is much easier than installing all the components separately.
</p>
<h3>Pre-Requisite: TextWrangler</h3>
<p>Please download and install TextWrangler from this site.  
</p>
<p><a href="http://www.barebones.com/products/TextWrangler/download.html" 
target="_new">http://www.barebones.com/products/TextWrangler/download.html</a>
</p>
<h3>Installing XAMPP</h3>
<p>
There is a screen cast of this process below on YouTube.  You can watch the screen cast
and follow along to complete the tasks.  There are notes below the YouTube video as well.
You may want to print this page to have the notes as you follow the steps in the video.
You may find that watching this on YouTube does not work so well because you may have a slow 
network connection, or you need to stop and start the video too often as you watch it.
Also the text is difficult to read on the YouTube version.
Below the video is a link to download the entire high-quality video to your desktop so 
you can play it locally with QuickTime.
</p>
<center>
<iframe width="480" height="390" src="http://www.youtube.com/embed/mzlvRFMNtHo" frameborder="0" allowfullscreen></iframe>
<p>
Download Entire Video: <a href="http://www-personal.umich.edu/~csev/courses/shared/podcasts/installing-xampp-macintosh.mov" target="_new">QuickTime</a> <br/>(Right-Click or Control-Click and Save this file)
</p>
</center>
<p>
<h3>Installation Notes</h3>
<p>
Download the installation package from:
<pre>
     <a href="http://www.apachefriends.org/en/xampp.html" target="_new">http://www.apachefriends.org/en/xampp.html</a>
</pre>
It will mount as a drive and you will need to drag the "XAMPP" folder into your "Applications"
folder.  Make sure you are doing this on an administrator account.
</p>
<img src="xampp-mac-02-panel.png" align="right"/>
<p>
Then Navigate into <b>/Applications/XAMPP/XAMPP Control Panel</b> to start the control panel.  
The control panel has two windows.  One window tells you the localhost URLs to use with XAMPP
and the other window is the XAMPP control panel itself.   You will need to Start both the 
Apache and MySql service.   When you press Start, you may be prompted for the administrator
password.  If you never put a password on the account, simply leave the password blank and
press "OK".  It may also prompt you for some fiewall settings or other trust dialog boxes.
</p>
<p>
If you are already running the built-in copy of the Apache web Server, you will have to turn 
it off before XAMPP will start.  If the Apple-provided Web Sharing is running, XAMPP will warn
you of this before it starts.  To turn Web Sharing on or off Navigate to:
<pre>
      <b>Apple Menu -> System Preferences -> Sharing</b>
</pre>
You may have to press the little "Unlock" button and then uncheck the "Web Sharing" tick box
and press the lock button to re-lock the preferences.  This turns off the built-in web server
so that XAMPP can connect to port 80.  You can flip this off and on as often as you like.  You
can switch back and forth between Apple's web server and XAMPP as long as only one is running
at any given time.
<br clear="all"/>
</p>
<p>
Once you get two little green indicators (Apache and MySql) in the XAMPP control panel, open
a web browser and point it to:
<pre>
     <a href="http://localhost/" target="_new">http://localhost/</a>
</pre>
It should initially start with an XAMPP splash screen so you can select your language
and then proceed to the XAMPP main screen with an orange navigation bar along the
right side.
</p>
<p>
<center>
<a href="xampp-mac-02-startup.png" target="_new"><img 
src="xampp-mac-02-startup.png" width="540"/></a>
</center>
</p>
<!--
<h3>Making your first MySql Database</h3>
<p>
Select the <b>phpMyAdmin</b> link from the left-hand XAMPP menu.  It should bring up 
phpMyAdmin in a new window showing the current databases on the left and the database
explorer in the right.  It should be on a screen that allows you to reate a new database.  
Enter your name (lower case no spaces) and press "Create".   The screen will refresh and a new
database will appear on the left navigation.  Congratulations - you have created your first
database in MySql!
<center>
<a href="phpmyadmin-00-create-db.png" target="_new">
<img src="phpmyadmin-00-create-db.png" width="540">
</a>
</center>
</p>
<p>
<b>Note:</b> Do not delete or modify the existing databases on the left hand side such as:
information_schema or mysql.  These are necessary for mysql to function properly.  In general
you should only modify or delete databases you created.
</p>
-->
<img src="phpmyadmin-01-htdocs-perms.png" align="right"/>
<h3>Your First PHP Program</h3>
<p>Before you can create your first PHP program we need to change the permissions on one 
of the folders to allow you to make changes to the folder.  Navigate to:
<pre>
    <b>/Applications/XAMPP/htdocs</b>
</pre>
And then in the Finder, choose <b>File -> Get Info</b>.
</p>
<p>
Scroll to the very bottom of the information dialog and find <b>Sharing &amp; Permissions</b>.
Press the little "Lock" so you can make changes and then change the permission for "admin" 
to "Read &amp; Write" and press the Lock icon again to re-lock the dialog.
</p>
<p>
Normally, we are not supposed to modify files in the <b>/Applications</b> area, but we will
be modifying files in this particular directory so we will have to give ourselves permission
to edit this folder.
</p>
<p>
Now that we have given ourselves permission to modify the web documents for our XAMPP server,
lets get back to building our first program.<br clear="all"/>
</p>
<p>
Open a text editor (i.e. TextWrangler) and put the following text in the file
putting your own name in instead of mine:
<pre>
&lt;h1&gt;Hello from Dr. Chuck's HTML Page&lt;/h1&gt;
</pre>
We will start simple and since PHP is simply an extension of HTML, our first program is 
just an HTML file.
</p><p>
Save this file as:
<pre>
    <b>/Applications/XAMPP/htdocs/si572/index.php</b>
</pre>
Create the folder <b>si572</b> under the <b>htdocs</b> folder when you save the file.  If you get
a permissions error while creating the folder or saving the file it likely means that you either
are not running as the administrator or you neglected to change the permissions on the
<b>htdocs</b> folder above.
</p>
<p>
Once you have saved this file, navigate your browser to:
<pre>
    <a href="http://localhost/si572/index.php" target="_new">http://localhost/si572/index.php</a>
</pre>
</p>
<p>
And you should see your web page in your browser.
<center>
<img src="assn00-01-first-page.png">
</center>
</p>
<p>
Once that works, lets add a little PHP to our HTML.  Change your file to be as follows
and re-save:
<pre>
&lt;h1&gt;Hello from Dr. Chuck's HTML Page&lt;/h1&gt;
&lt;p&gt;
&lt;?php
   echo "Hi there.\n";
   $answer = 6 * 7;
   echo "The answer is $answer, what was the question again?\n";
?&gt;
&lt;/p&gt;
&lt;p&gt;Yes another paragraph.&lt;/p&gt;
</pre>
After you save, press "Refresh" in your browser and it should appear as follows:
</p>
<p>
<center>
<img src="assn00-02-first-page.png">
</center>
</p>
<p>
Congratulations, you have written your first PHP program.
</p>
<h3>Displaying Syntax Errors</h3>
<p>
XAMPP usually comes configured by default <b>not</b> to display errors when you
make a mistake in your PHP code.  This is an appropriate setting for production
servers but very inconvienent when developing PHP code.
</p><p>
The solution is to find and edit the <b>php.ini</b> file that controls
the XAMPP configuration, search for the setting <b>display_errors</b>
and set the value to <b>On</b> and then restart your Apache server.
</p>
<p>
On XAMPP the php.ini file is located by default here:
<pre>
/Applications/XAMPP/xamppfiles/etc/php.ini
</pre>
You can always find where php.ini is by looking at your PHPInfo screen.
You should find and change the setting to be:
<pre>
display_errors = On
</pre>
</p>
<p>
There is a screen cast of this process below on YouTube.  The quality of the
YouTube version is not too good so you may want to
Also the text is difficult to read on the YouTube version.
download the entire high-quality video to your desktop so
you can play it locally with QuickTime using the link below.
</p>
<center>
<iframe width="480" height="390" src="http://www.youtube.com/embed/dz-TQDQ1oyg"
frameborder="0" allowfullscreen></iframe>
<p>
Download Entire Video:
<a href="http://www-personal.umich.edu/~csev/courses/shared/podcasts/fixing-php-ini-xampp.mov"
target="_new">QuickTime</a> <br/>(Right-Click or Control-Click and Save this file)
</p>
</center>


</div>
<!-- Don't use footer because we don't want chat -->
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
var pageTracker = _gat._getTracker("UA-423997-6");
pageTracker._initData();
pageTracker._trackPageview();
</script>
</body>
</html>
