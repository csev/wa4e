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
<h3>Pre-Requisite: VSCode, Atom or some other Programming Editor</h3>
<p><a href="https://code.visualstudio.com/" target="_blank">https://code.visualstudio.com/</a>
</p>
<h3>Installing MAMP</h3>
<p>
There is a screen cast of this process below on YouTube.  You can watch the screen cast
and follow along to complete the tasks.  There are notes below the YouTube video as well.
You may want to print this page to have the notes as you follow the steps in the video.
</p>
<center>
<iframe width="480" height="390" src="https://www.youtube.com/embed/CwwF801i5_4" frameborder="0" allowfullscreen></iframe>
</center>
<p>
<h3>Installation Notes</h3>
<p>
Download the installation package from:
<pre>
     <a href="http://mamp.info/" target="_blank">http://mamp.info</a>
</pre>
It will download into your <b>Downloads</b> folder as a rather large ZIP file.  
Depending on your browser, it may auto-extract 
the ZIP into a file like <b>MAMP_MAMP_PRO_4.1.pkg</b>.  If your browser does not auto-extract ZIP
files, click on the ZIP file to produce the PKG file.   Click on the PKG file to perform
the actual install.
Make sure you are doing this on an administrator account.  You probably will have to 
enter the password for the administrator account during installation.
</p>
<p>
Then Navigate into <b>/Applications/MAMP/MAMP</b> to start the control panel.  
The first time you start MAMP it might suggest you use MAMP Pro - you can ignore this.
</p>
<p>
To stop the nagging, <b>uncheck</b> the check box and click on <b>Launch MAMP</b> - that should 
stop the nagging for a while.  
</p>
<center>
<img src="images/mamp-03-control.png" width="240"/>
</center>
<p>
When MAMP starts you should see a control panel and it should start both the MySQL and 
Apache Servers automatically.   It also generally opens the start page automatically as well.
The control panel allows you to start and stop the servers and go the the start page.
Once the control panel is working - you don't use it very much.<br clear="all"/>
</p>
<p>
The start page is located at <b>http://localhost:8888/MAMP/</b> and it is generally the way you work 
with MAMP and MySql.
<center>
<img src="images/mamp-03-start-page.png" width="480" /></center>
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
<a href="phpmyadmin-00-create-db.png" target="_blank">
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
Open a text editor (i.e. VSCode) and put the following text in the file
putting your own name in instead of mine:
<pre>
&lt;h1&gt;Hello from Dr. Chuck's HTML Page&lt;/h1&gt;
</pre>
We will start simple and since PHP is simply an extension of HTML, our first program is 
just an HTML file.
</p><p>
Save this file as:
<pre>
    <b>/Applications/MAMP/htdocs/first/index.php</b>
</pre>
Create the folder <b>first</b> under the <b>htdocs</b> folder when you save the file.  
</p>
<p>
Once you have saved this file, navigate your browser to:
<pre>
    <a href="http://localhost:8888/first/index.php" target="_blank">http://localhost:8888/first/index.php</a>
</pre>
</p>
<p>
And you should see your web page in your browser.
<center>
<img src="images/mamp-04-first-01.png">
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
<img src="images/mamp-05-first-02.png">
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
/Applications/MAMP/bin/php/php7.1.0/conf/php.ini
</pre>
The "7.1.0" might be different on your system.
You can always find where php.ini is by looking at your PHPInfo screen.
</p>
You should find and change the setting to be:
<pre>
display_errors = On
</pre>
<p>
Then you will need to stop and restart the Apache and MySQL servers 
using the MAMP, control panel and when you are done, you can use
<b>phpinfo</b> check to make sure that your setting was successfully
changed.
<center>
<img src="images/mamp-06-errors.png">
</center>
<p>
It is important that you change this setting right away or you 
will be rather confused when your PHP code fails and you 
never see any error message.
</p>


