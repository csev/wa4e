<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php include("header.php"); ?>
</head>
<body style="margin: 10px">
<div id="main">
<h3>
Setting up the MAMP PHP/MySql Environment on a Macintosh
</h3>
<p>We will install the MAMP bundled PHP/MySql system.  Installing the MAMP
(or similar) bundle is much easier than installing all the components separately.
</p>
<h3>Pre-Requisite: TextWrangler</h3>
<p>Please download and install TextWrangler from this site.  
</p>
<p><a href="http://www.barebones.com/products/TextWrangler/download.html" 
target="_new">http://www.barebones.com/products/TextWrangler/download.html</a>
</p>
<h3>Installing MAMP</h3>
<p>
There is a screen cast of this process below on YouTube.  You can watch the screen cast
and follow along to complete the tasks.  There are notes below the YouTube video as well.
You may want to print this page to have the notes as you follow the steps in the video.
You may find that watching this on YouTube does not work so well because you may have a slow 
network connection, or you need to stop and start the video too often as you watch it.
Also the text is hard to read on the YouTube version of the file.
Below the video is a link to download the entire high-quality video to your desktop so 
you can play it locally with QuickTime.
</p>
<center>
<iframe width="480" height="390" src="http://www.youtube.com/embed/FC0DydeeTTk" frameborder="0" allowfullscreen></iframe>
<p>
Download Entire Video: <a href="http://afs.dr-chuck.com/courses/shared/podcasts/installing-mamp-macintosh.mp4" target="_new">QuickTime</a> <br/>(Right-Click or Control-Click and Save this file)
</p>
</center>
<p>
<h3>Installation Notes</h3>
<p>
Download the installation package from:
<pre>
     <a href="http://mamp.info/" target="_new">http://mamp.info</a>
</pre>
It will download into your <b>Downloads</b> folder as a rather large ZIP file.  
Depending on your browser, it may auto-extract 
the ZIP into a file like <b>MAMP_2.1.1.pkg</b>.  If your browser does not auto-extract ZIP
files, click on the ZIP file to produce the PKG file.   Click on the PKG file to perform
the actual install.
Make sure you are doing this on an administrator account.
</p>
<img src="mamp-01-pro-bother.png" width="360" align="right"/>
<p>
Then Navigate into <b>/Applications/MAMP/MAMP</b> to start the control panel.  
The first time you start MAMP it will nag you to use MAMP Pro.
</p>
<p>
To stop the nagging, <b>uncheck</b> the check box and click on <b>Launch MAMP</b> - that should 
stop the nagging for a while.  
<em>(Optional) If you really want to clean up the nagging, you can go into 
<b>/Applications/MAMP PRO/MAMP Pro Uninstaller</b> and uninstall MAMP Pro.   Check all the check 
boxes as part of the uninstall.  Voila!  You have MAMP <b>Not</b> Pro.</em>
<br clear="all">
</p>
<p>
<img src="mamp-03-control.png" width="240" align="right"/></center>
When MAMP starts you should see a control panel and it should start both the MySQL and 
Apache Servers automatically.   It also generally opens the start page automatically as well.
The control panel allows you to start and stop the servers and go the the start page.
Once the control panel is working - you don't use it very much.<br clear="all"/>
</p>
<p>
The start page is located at <b>http://localhost:8888/MAMP/</b> and it is generally the way you work 
with MAMP and MySql.
<center>
<img src="mamp-03-start-page.png" width="480" /></center>
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
<h3>Your First PHP Program</h3>
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
    <b>/Applications/MAMP/htdocs/howdy/index.php</b>
</pre>
Create the folder <b>howdy</b> under the <b>htdocs</b> folder when you save the file.  
</p>
<p>
Once you have saved this file, navigate your browser to:
<pre>
    <a href="http://localhost:8888/howdy/index.php" target="_new">http://localhost:8888/howdy/index.php</a>
</pre>
</p>
<p>
And you should see your web page in your browser.
<center>
<img src="mamp-04-howdy-01.png">
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
<img src="mamp-05-howdy-02.png">
</center>
</p>
<p>
Congratulations, you have written your first PHP program.
</p>
<h3>Displaying Syntax Errors</h3>
<p>
MAMP usually comes configured by default <b>not</b> to display errors when you
make a mistake in your PHP code.  This is an appropriate setting for production
servers but very inconvienent when developing PHP code.
</p><p>
The solution is to find and edit the <b>php.ini</b> file that controls
the XAMPP configuration, search for the setting <b>display_errors</b>
and set the value to <b>On</b> and then restart your Apache server.
</p>
<p>
On MAMP the php.ini file is located here:
<pre>
/Applications/MAMP/bin/php/php5.3.6/conf/php.ini
</pre>
The "5.3.6" might be different on your system.
You can always find where php.ini is by looking at your PHPInfo screen.
</p>
You should find and change the setting to be:
<pre>
display_errors = On
</pre>
<p>
There is a screen cast of this process below on YouTube.  The quality of the
YouTube version is not too good so you may want to
Also the text is difficult to read on the YouTube version.
download the entire high-quality video to your desktop so
you can play it locally with QuickTime using the link below.
</p>
<center>
<iframe width="480" height="390" src="http://www.youtube.com/embed/GQK0kwnSPy4"
frameborder="0" allowfullscreen></iframe>
<p>
Download Entire Video:
<a href="http://afs.dr-chuck.com/courses/shared/podcasts/fixing-php-ini-mamp.mov"
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
