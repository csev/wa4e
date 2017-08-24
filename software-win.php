<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php include("header.php"); ?>
</head>
<body style="margin: 10px">
<div id="main">
<h3>
Setting up the PHP/MySql XAMPP Environment on Windows
</h3>
<p>We will install the XAMPP bundled PHP/MySql system.  Installing the XAMPP
(or similar) bundle is much easier than installing all the components separately.
</p>
<h3>Pre-Requisite: Atom, NotePad++ or some other Programming Editor</h3>
</p>
<p><a href="https://atom.io/" target="_blank">https://atom.io/</a>
</p>
<h3>Installing XAMPP</h3>
<p>
There is a screen cast of this process below on YouTube.  You can watch the screen cast
and follow along to complete the tasks.  There are notes below the YouTube video as well.
You may want to print this page to have the notes as you follow the steps in the video.
</p>
<center>
<iframe width="640" height="360" src="https://www.youtube.com/embed/X0_pthMQPMM" frameborder="0" allowfullscreen></iframe>
</center>
<p>
<h3>Installation Notes</h3>
<p>
Download the installation package from:
<pre>
     <a href="https://www.apachefriends.org/index.html" target="_blank">https://www.apachefriends.org/index.html</a>
</pre>
I choose the "Installer" (i.e. neither the ZIP nor 7zip) installation package.  
Download the package to your desktop and once the download is complete, run the installer,
and go through the installation steps.
Make sure you are doing this on an administrator account.
</p>
<h3>Starting the XAMPP Control Panel Application</h3>
<p>
If you installed XAMPP in the default location, you can find it at:
<pre>
    <b>C:\XAMPP\xampp-control.exe</b>
</pre>
You can pin this to your task bar once it starts to make it easier to launch.
</p>
<p>
You will need to Start both the Apache and MySql service.   
When you press Start, you may be prompted for 
some firewall settings or other trust dialog boxes.  Make sure to say 'yes' to these trust boxes.
Generally you will only see these trust dialogs once.
</p>
<center>
<a href="images/xampp-win-01-panel.png" target="_blank">
<img src="images/xampp-win-01-panel.png" border="2px" width="50%"/>
</a>
</center>
<p>
Once you get two little green "Running" indicators (Apache and MySql) in the XAMPP control panel, 
you can press the "Admin..." button next to Apache to launch the XAMPP user interface.
Note that the "Admin..." button next to MySql seems not to function.  Don't worry about that.
You could also bring up the XAMPP start screen by navigating your web browser to:
<pre>
     <a href="http://localhost/" target="_blank">http://localhost/</a>
</pre>
It should initially start with an XAMPP splash screen so you can select your language
and then proceed to the XAMPP main screen with an orange navigation bar along the
right side.
</p>
<p>
<center>
<a href="images/xampp-win-02-startup.png" target="_blank"><img 
src="images/xampp-win-02-startup.png" width="80%" border="2px"/></a>
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
Open a text editor (i.e. Atom) and put the following text in the file
putting your own name or something elese uniquely identifying in instead of mine:
<pre>
&lt;h1&gt;Hello from Dr. Chuck's HTML Page&lt;/h1&gt;
</pre>
We will start simple and since PHP is simply an extension of HTML, our first program is 
just an HTML file.
</p><p>
Save this file as:
<pre>
    <b>C:\xampp\htdocs\first\index.php</b>
</pre>
Create the folder <b>first</b> under the <b>htdocs</b> folder when you save the file.  If you get
a permissions error while creating the folder or saving the file it likely means that you either
are not running as the administrator.
</p>
<p>
Once you have saved this file, navigate your browser to:
<pre>
    <a href="http://localhost/first/index.php" target="_blank">http://localhost/first/index.php</a>
</pre>
</p>
<p>
And you should see your web page in your browser.
<center>
<a href="images/assn00-01-first-page-win.png" target="_blank">
<img src="images/assn00-01-first-page-win.png" width="50%" border="2px">
</a>
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
<a href="images/assn00-02-first-page-win.png" target="_blank">
<img src="images/assn00-02-first-page-win.png" width="50%" border="2px">
</a>
</center>
</p>
<p>
Congratulations, you have written your first PHP program.
</p>
<h3>Displaying Syntax Errors</h3>
<p>
XAMPP usually comes configured by default to display errors when you 
make a mistake in your PHP code.  This is an appropriate setting 
cwwhile developingdevelopers. 
</p><p>
To verify this, go into the XAMPP control panel and select 
<b>Config</b> and then <b>php.ini</b>.  This will being up a NotePad
with the PHP configuration.  Scroll down to verify that:
<pre>
display_errors=On
</pre>
<center>
<a href="images/xampp-win-03-ini-notepad.png" target="_blank">
<img src="images/xampp-win-03-ini-notepad.png" width="80%"border="2px">
</a>
</center>
</p>
<p>
If it is <b>Off</b> change it to <b>On</b> and then go back to the XAMPP
Control Panel and stop and then restart the Apahce server.   Then go back to
<b>Admin</b> page and check the <b>PHPInfo</b> page to make sure that 
display_errors is indeed <b>On</b>.
<center>
<a href="images/xampp-win-04-php-info.png" target="_blank">
<img src="images/xampp-win-04-php-info.png" width="80%" border="2px">
</a>
</center>
</body>
</html>
