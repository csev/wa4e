Using LocalTunnel on Windows
==============================

In this document we show you how to submit your running application to the
autograder.  The PHP autograder wants to "use" your application and test it
by sending requests and checking the responses from your application.

<center><a href="ngrok_mac/00-autograder.png" target="_blank"><img src="ngrok_mac/00-autograder.png" style="width:80%; border: 1px black solid;"></a></center>

You cannot submit a URL like `http://localhost/homework/guess.php`
because "localhost" only works for network conections originating *within*
your computer and your computer protects your computer from
incoming connectsion (i.e. they are blocked by a firewall).

Unless you install your application on a server with Internet
connectivity and a domain name, you need to use a program like `localtunnel` to
submit your program to the autograder.

Applications like localTunnel (or ngrok) can make a temporary hole
through your firewall and give you a temporary domain name you can
use to submit your application to the Autograder.

LocalTunnel is a free product and service and is suitable for use for
this class.  If you want a more full-featured product, you might be interested
in "ngrok" which has a "freemium" pricing model.

Video Tutorial
--------------

You can watch a video demonstrating the use of LocalTunnel on Windows at:

<a href="https://www.youtube.com/watch?v=-Rh9S9zqAYQ&list=PLlRFEj9H3Oj7FHbnXWviqQt0sKEK_hdKX" target="_blank">https://www.youtube.com/watch?v=-Rh9S9zqAYQ</a>

Installing LocalTunnel
----------------------

You have two choices as to how to install LocalTunel.  

(a) You can visit
<a href="https://localtunnel.me/" target="_blank">https://localtunnel.me/</a>
And follow their (rather complex) instructions. 

or

(b) If you take a look at their instructions and find them too complex, we
have simplified the install into a single download:

<a href="../downloads/lt-win.zip">Download LocalTunnel for Windows</a>
When you download the file it will probably end up in `Downloads`
folder.  
The ZIP file will probably automatically open so you can copy the
`lt-win` executable file to a folder on your system such as the Desktop.

<center><a href="lt_win/01-downloads.png" target="_blank"><img src="lt_win/01-downloads.png" style="width:60%; border: 1px black solid;"></a></center>

To run `lt-win` from the `Desktop` folder, start a Command prompt and type:

    cd Desktop
    lt-win -p 80
    your url is: https://vgbyqzdlcd.localtunnel.me


You should note the temporary URL that LocalTunnel has assigned you 
for use later.
In this example, the temporary URL is `https://vgbyqzdlcd.localtunnel.me`.

Leave `lt-win` running in this window.

You can also move the `lt-win` file to another folder.

Checking Your Application Locally
---------------------------------

First make sure that you know that your application is running on localhost:

<center><a href="lt_win/03-localhost.png" target="_blank"><img src="lt_win/03-localhost.png" style="width:60%; border: 1px black solid;"></a></center>

Checking Your Application Via the Tunnel
----------------------------------------

Construct the LocalTunnel url by removing 
the "http://localhost" and replace it
with the LocalTunnel-provided URL:

    Local:  http://localhost/php-solutions/assn/guess/guess.php
    Tunnel: http://vgbyqzdlcd.localtunnel.me/php-solutions/assn/guess/guess.php

Test that url in your browser.  The LocalTunnel and local urls should
return the exact same page.

<center><a href="lt_win/04-localtunnel.png" target="_blank"><img src="lt_win/04-localtunnel.png" style="width:80%; border: 1px black solid;"></a></center>

Once you have verifed your application is working, submit the LocalTunnel url
to the autograder.

<center><a href="lt_win/06-autograder.png" target="_blank"><img src="lt_win/06-autograder.png" style="width:80%; border: 1px black solid;"></a></center>

Closing LocalTunnel
-------------------

You can press `CTRL-C` in the LocalTunnel terminal window or simply close the
LocalTunnel window.

Remember that each time you start `lt-win`, it will assign you a different
random address.







