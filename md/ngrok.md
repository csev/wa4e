Using Ngrok on Macintosh
========================

In this document we show you how to submit your running application to the
autograder.  The PHP autograder wants to "use" your application and test it
by sending requests and checking the responses from your application.

<center><a href="ngrok_mac/00-autograder.png" target="_blank"><img src="ngrok_mac/00-autograder.png" style="width:80%; border: 1px black solid;"></a></center>

You cannot submit a URL like `http://localhost:8888/homework/quess.php`
because "localhost" only works for network conections originating *within*
your computer and your computer protects your computer from
incoming connectsion (i.e. they are blocked by a firewall).

Unless you install your application on a server with Internet
connectivity and a domain name, you need to use a program like `ngrok` to
submit your program to the autograder.

Applications like ngrok (or localtunnel) can make a temporary hole
through your firewall and give you a temporary domain name you can
use to submit your application to the Autograder.

Installing Ngrok
----------------

First you need to download and install ngrok from
<a href="https://www.ngrok.com" target="_blank">www.ngrok.com</a>.
When you download the file it will probably end up in `Downloads`
folder.  You can double-click the ZIP file to unzip it to create a file
named `ngrok`;

<center><a href="ngrok_mac/01-downloads.png" target="_blank"><img src="ngrok_mac/01-downloads.png" style="width:40%; border: 1px black solid;"></a></center>

To run `ngrok` from the `Downloads` folder, in the terminal window type:

    cd ~/Downloads
    ./ngrok http 8888

Ngrok should start up and show a user interface like this:

<center><a href="ngrok_mac/02-running.png" target="_blank"><img src="ngrok_mac/02-running.png" style="width:90%; border: 1px black solid;"></a></center>

You should note the temporary URL that ngrok has assigned you for use later.
In this example, the temporary URL is `http://f01f774d.ngrok.io` - record
that for later.

Checking Your Application Locally
---------------------------------

First make sure that you know that your application is running on localhost:

<center><a href="ngrok_mac/03-localhost.png" target="_blank"><img src="ngrok_mac/03-localhost.png" style="width:60%; border: 1px black solid;"></a></center>

Checking Your Application Via NGrok
-----------------------------------

Construct the ngrok url by removing the "http://localhost:8888" and replace it
with the ngrok-provided URL:

    Local: http://localhost:8888/wa4e/solutions/guess/guess.php
    Ngrok: http://f01f774d.ngrok.io/wa4e/solutions/guess/guess.php

Test that url in your browser.  The ngrok and local urls should
return the exact same page.

<center><a href="ngrok_mac/04-ngrok.png" target="_blank"><img src="ngrok_mac/04-ngrok.png" style="width:60%; border: 1px black solid;"></a></center>

Once you have verifed your application is working, submit the ngrok url
to the autograder.

<center><a href="ngrok_mac/06-autograder.png" target="_blank"><img src="ngrok_mac/06-autograder.png" style="width:60%; border: 1px black solid;"></a></center>

Interestingly, ngrok shows you as it is forwarding the various HTTP requests
back and forth.

<center><a href="ngrok_mac/07-rrc.png" target="_blank"><img src="ngrok_mac/07-rrc.png" style="width:60%; border: 1px black solid;"></a></center>


Closing Ngrok
-------------

You can press `CTRL-C` in the ngrok terminal window or simply close the
ngrok window.

Remember that each time you start `ngrok`, it will assign you a different
random address.







