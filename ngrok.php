<!DOCTYPE html>
<html>
<head>
<?php include("header.php"); ?>
</head>
<body style="margin: 10px">
<div id="main">
<h3>
Autograding using NGROK
</h3>
<p>
In order to use an autograder to grade your web sites running on your 
local computer, we need to be able to access 
the web server running on your laptop or personal computer. In general, home gateways
and most campus networks or coffee shops block incoming connections to your computer
when you are connected to their network.  This is very much on purpose and is designed
to protect your computer from being attacked and compromised whenever it connects to the 
internet.
</p>
<p>
So while you can test your applications locally by connecting to the 
"loop-back" address using "localhost" and urls like:
<pre>
http://localhost/php-intro/assn01/
http://localhost:8080/php-intro/assn01/
http://localhost:8888/php-intro/assn01/
</pre>
So even if you knew the loack IP (Internet Protocol) address of your computer, it is not possible 
to connect from the internet to your computer due to a gateway or firewall.
</p>
<p>
But we need to be able to have our autograding software connect to your local web server to 
grade your assignments.  And to so this, we use a piece of software called "ngrok" to give 
your local web server a internet-accessible address for a short period of time.
</p>
<h3>
Installing ngrok for autograding
</h3>
<p>
Installing ngrok is very simple, you can download a ZIP file from 
<a href="https://ngrok.com/" target="_blank">https://ngrok.com/</a> and 
unzip that file anywhere on your computer.  You might want to read the documentation
on the web site to familiarize yourself with ngrok.  They have nice diagrams that 
explain how ngrok works and why ngrok is needed to allow access to your local web server.
</p>
<h3>Running Ngrok on Apple</h3>
<p>
Download the ngrok.zip file to your <b>Downloads</b> folder and then extract it by double clicking on
the downloaded file and it will unzip and produce a single file called <b>ngrok</b>.  You can put this 
file anywhere on your computer but for now we will just execute it from the <b>Downloads</b> folder.
Make sure your web server (Apache, MAMP, etc..) is up and running and then 
open up a Terminal Window as follows:
<pre>
$ cd Downloads/
$ ls
ngrok               ngrok_2.0.19_darwin_amd64.zip
$ ./ngrok http 8888

Tunnel Status       online                                            
Version             2.0.19/2.0.19                                     
Web Interface       http://127.0.0.1:4040                             
Forwarding          http://c5343c6e.ngrok.io -&gt; localhost:8888        
Forwarding          https://c5343c6e.ngrok.io -&gt; localhost:8888       
                                                                                
Connections         ttl     opn     rt1     rt5     p50     p90       
                    0       0       0.00    0.00    0.00    0.00 
</pre>
Replace "8888" with whatever port your web server is running on.  Then nagivate in your browser
to the address that ngrok has chosen for you.  Do not include the port number on the ngrok address.
<pre>
http://c5343c6e.ngrok.io
</pre>
At that point you should see the same thing as you would see if you went to 
<pre>
http://localhost:8888/
</pre>
And you can go to paths other than the root like:
<pre>
http://c5343c6e.ngrok.io/guess/index.php
</pre>
Your local web server will be visible to the Internet at the ngrok-chosen address
until you end the <b>ngrok</b> application.  To terminate the <b>ngrok</b> on the 
Apple, simply press "CTRL-C" to aport the program.  At that point, your local web
server can no longer be accessed through ngrok.
</p>
<p>
Each time you run <b>ngrok</b> you will get a new address unless you sign up and pay for an
address that does not change each time you run it.
</p>
<h3>Running Ngrok on Windows</h3>
<p>
Download the ngrok.zip file to your <b>Downloads</b> folder and then extract it by clicking on
the downloaded file and selecting "Extract All".  It will make a folder like "ngrok_2.0.19_windows_386"
and in that folder, you will find a single file named <b>ngrok.exe</b>.  You 
You can put this 
file anywhere on your computer but for now we will just execute it from the <b>Downloads</b> folder.
Make sure your web server (XAMPP, MAMP, etc..) is up and running and then 
open up a Command Line window as follows:
<pre>
C:\...&gt; cd Downloads\ngrok_2.0.19_windows_386
C:\...&gt; ngrok http 8080

Tunnel Status       online                                            
Version             2.0.19/2.0.19                                     
Web Interface       http://127.0.0.1:4040                             
Forwarding          http://c5343c6e.ngrok.io -&gt; localhost:8080        
Forwarding          https://c5343c6e.ngrok.io -&gt; localhost:8080       
</pre>
Replace "8080" with whatever port your web server is running on.  Then nagivate in your browser
to the address that ngrok has chosen for you.  Do not include the port number on the ngrok address.
<pre>
http://c5343c6e.ngrok.io
</pre>
At that point you should see the same thing as you would see if you went to 
<pre>
http://localhost:8080/
</pre>
And you can go to paths other than the root like:
<pre>
http://c5343c6e.ngrok.io/guess/index.php
</pre>
Your local web server will be visible to the Internet at the ngrok-chosen address
until you end the <b>ngrok</b> application.  To terminate the <b>ngrok</b> on the 
Apple, simply press "CTRL-Z" to aport the program.  At that point, your local web
server can no longer be accessed through ngrok.
</p>
<p>
Each time you run <b>ngrok</b> you will get a new address unless you sign up and pay for an
address that does not change each time you run it.
</p>
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

