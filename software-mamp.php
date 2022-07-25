<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php include("header.php"); ?>
<style>
img { 
  border: 1px black solid;
}
</style>
</head>
<body style="margin: 10px">
<div id="main">
<h3>
Setting up the MAMP PHP/MySql Environment on Windows
</h3>
<p>We will install the MAMP bundled PHP/MySql system.  Installing the MAMP
(or similar) bundle is much easier than installing all the components separately.
</p>
<h3>Pre-Requisite: VSCode or some other Programming Editor</h3>
<p><a href="https://code.visualstudio.com/" target="_blank">https://code.visualstudio.com/</a>
</p>
<h3>Installing MAMP</h3>
<p>
There is a screen cast of this process below on YouTube.  You can watch the screen cast
and follow along to complete the tasks.  There are notes below the YouTube video as well.
You may want to print this page to have the notes as you follow the steps in the video.
</p>
<center>
<iframe width="480" height="270" src="https://www.youtube.com/embed/0P6DEUJaVTc" frameborder="0" allowfullscreen></iframe>
</center>
<p>
<h3>Installation Notes</h3>
<p>
Download the installation package from:
<pre>
     <a href="http://mamp.info/" target="_blank">http://mamp.info</a>
</pre>
Assuming you are using the Microsoft browser, it
will download and automatically start the installer for you.   We can accept all the defaults,
but you might not want to install MAMP Pro so it does not nag you to upgrade.
</p>
<center>
<img src="images/mamp-win-01-no-pro.png" width="40%"/>
</center>
<p>
The installer has placed <b>MAMP</b> on your Desktop, so you can clck on it to launch it.
</p>
<center>
<img src="images/mamp-win-02-launch.png" width="50%"/>
</center>
<p>
When MAMP starts you should see a control panel. Press "Start Servers" if they are automatically
started.  Be patient, these things can take a moment.  
</p>
<p>
The first time you start the server, Windows will ask you to verify that Apache and MySQL
are indeed allowed to use the network ports to receive traffic.  If you do not see these messages,
you may need to run the installation as an administrator.
<center>
<img src="images/mamp-win-03-firewall.png" width="40%"/>
</center>
<p>
You should see two indicators that both the Apache and MySQL servers were started successfully.
</p>
<center>
<img src="images/mamp-win-04-green.png" width="40%"/>
</center>
<p>
Then press the "Open start page" to show the MAMP configuration screen.
The start page is located at <b>http://localhost/MAMP/</b> and it is generally the way you work 
with MAMP and MySql.
<center>
<img src="images/mamp-win-04-green.png" width="40%" /></center>
</p>
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
    <b>C:\MAMP\htdocs\first\index.php</b>
</pre>
Create the folder <b>first</b> under the <b>htdocs</b> folder when you save the file.  
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
<img src="images/mamp-win-06-first.png">
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
<img src="images/mamp-win-07-first.png">
</center>
</p>
<p>
Congratulations, you have written your first PHP program.
</p>
<h3>Displaying Syntax Errors</h3>
<p>
MAMP usually comes configured by default <b>not</b> to display error detail when you
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
C:\MAMP\conf\php7.1.5\php.ini
</pre>
The "7.1.5" might be different on your system.
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
<img src="images/mamp-win-08-errors.png">
</center>
<p>
It is important that you change this setting right away or you 
will be rather confused when your PHP code fails and you 
never see any error message.
</p>


