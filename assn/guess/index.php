<?php
require_once("../assn_util.php");
$json = loadPeer("peer.json");
?>
<!DOCTYPE html>
<html>
<head>
<title>Assignment: <?= $json->title ?></title>
<style>
li { padding: 5px; }
</style>
</head>
<body style="margin-left:5%; margin-bottom: 60px; margin-right: 5%; font-family: sans-serif;">
<h1>Assignment: <?= $json->title ?></h1>
<p>
<?= $json->description ?>
</p>
<?php if ( isset($json->solution) ) { ?>
<h2>Sample solution</h2>
<p>
You can explore a sample solution for this problem at
<pre>
<a href="<?= $json->solution ?>" target="_blank"><?= $json->solution ?></a>
</pre>
This sample solution won't completly pass the autograder.  It needs some work
to meet the specifications.  You can download the code for the partially complete
sample solution at:
<pre>
<a href="http://www.wa4e.com/code/arrays.zip" target="_blank">http://www.wa4e.com/code/arrays.zip</a>
</pre>
<?php } ?>
<h2>Resources</h2>
<p>There are several sources of information so you can do the assignment:
<ul>
<li>Lectures and materials on <i>Expressions and Control Flow in PHP</i> 
and <i>PHP Arrays</i> from 
<a href="http://www.wa4e.com" target="_blank">www.wa4e.com</a></li>
<li> Chapters 27, 28, and 31 from the free textbook
<a href="http://textbooks.opensuny.org/the-missing-link-an-introduction-to-web-development-and-programming/"
target="_blank">The Missing Link: An Introduction to Web Development and Programming</a> written by
<a href="http://textbooks.opensuny.org/author/mmendez/" target="_blank">Michael Menendez</a>
and published by
<a href="http://textbooks.opensuny.org/the-missing-link-an-introduction-to-web-development-and-programming/" 
target="_blank">Open SUNY Textbooks</a>.
<li><a href="http://www.ngrok.com/" target="_blank">NGROK</a> - A tool 
to create temporary secure tunnels from a local server to the Internet.
</li>
</ul>
</p>
<h2>Specifications</h2>

Since this assignment will be graded using an autograder (see below), your
code must match to match the wording and error messages in the sample application 
precisely.   
<center>
<a href="01-guess-too-high.png" target="_blank">
<img src="01-guess-too-high.png" width="80%"></a>
</center>
</p>
<p>
The autograder will randomly choose the "correct number" for your application so you will 
have to modify the sample code to adjust the correct answer.   You also will need to add
your name to the &lt;title&gt; tag in order for you to be given a grade for the assignment.
</p>
<p>
The autograder will run the following tests on your application:
<ul>
<li>
It will look at the contents of the &lt;title&gt; tag and insist your name is part of the title of the page.  If your name is not in the title, all of the tests will be run but no grade will be sent.</li>
<li>
It will call your program with no parameters at all and your program should say, "Missing guess parameter".
</li>
<li>
It will call your code with a non-numeric value and your code should say, "Your guess is not a number".
</li>
<li>
It will call your code with a low guess and your code should say, "Your guess is too low".
</li>
<li>
It will call your code with a too high guess and your code should say, "Your guess is too high".
</li>
<li>
It will call your code with the right value and your code should say, "Congratulations - You are right".
</ul>
</p>
<h2>Submitting your Assignment to the Autograder</h2>
<p>
This assignment will be graded by an online autograder that will actually connect to your site, 
request pages, and check the pages to verify correct implementation of the specifications.
You will need to submit a URL that points to your application that can be accessed
from the Internet.
</p>
<p>
If your application has a real URL (i.e. not "localhost") then you can submit that URL
to the autograder.   But if your application that is running on your
laptop or desktop computer with a URL like <strong>http://localhost...</strong> you
will need to install and use the <a href="https://ngrok.com/" target="_blank">ngrok</a>
application to get a temporary URL that can be submitted to the autograder this application.
</p>
<p>
Depending on where you put your <b>guess.php</b> relative to the <b>DOCUMENT_ROOT</b> of
your PHP server, you will have a local URL to run your application similar to the following:
<center>
<a href="04-pre-ngrok.png" target="_blank">
<img src="04-pre-ngrok.png" width="80%"></a>
</center>
Note the part of the URL after the host and port name.
</p>
<p>
Download the ngrok ZIP file from the web site and extract it to your 
Desktop.  Then open a terminal window or Windows command line:
<pre>
Macintosh:

    cd Desktop
    ./ngrok http 8888

Windows

    cd Desktop
    ngrok http 80
</pre>
The last parameter to ngrok is the port where your Apache server is running.
</p>
<p>
Once ngrok is up and running, you should see a screen similar to this:
<center>
<a href="05-ngrok-running.png" target="_blank">
<img src="05-ngrok-running.png" width="80%"></a>
</center>
Note the domain name and URL that NGROK has assigned to your local server.
</p>
<p>
Concatenate the URL from ngrok with the URL suffix from your localhost URL and
enter that URL in the browser as follows:
<center>
<a href="06-post-ngrok.png" target="_blank">
<img src="06-post-ngrok.png" width="80%"></a>
</center>
Make <strong>sure</strong> that you can see your application when it is being
accessed by the ngrok URL.  If you cannot see your application at the ngrok URL,
the autograder will also not be able to see the application.  So if t is not working,
do not proceed to the next step until you figure out why it is not working.
</p>
<p>
Nagivate to the autograder for the assignment in your LMS as directed by te instructor
and submit the ngrok URL to the autograder:
<center>
<a href="07-submit-ngrok.png" target="_blank">
<img src="07-submit-ngrok.png" width="80%"></a>
</center>
When you press "Evaluate", the autograder will start makking connections to your
web server therough ngrok.   The ngrok display will start showing the requests
as the autograder makes requests.
</p>
<p>
If you want more detail, you can monitor the requests
in an inspector by nagivating your browser to <a href="http://localhost:4040" target="_blank">
http://localhost:4040</a> while ngrok is running.
</p>
<p>

<h2>Sample Execution of the Autograder</h2>
<p>
The following is a sample execution of the autograder on the sample application:
<center>
<a href="10-autograde-toggle.png" target="_blank">
<img src="10-autograde-toggle.png" width="80%"></a>
</center>
The autograder tells you each URL it is retrieving and gives you the option to 
show the actual retrieved page that came from your server.  It also tells you 
what it is expecting to see in the page and then if it does not find what it is
looking for, it says <span style="color:red">Not found</span>.
</p>
<p>
The best way to figure out why the autograder is unhappy with your application
is to the toggle the most recently retrieved page directly aboce the 
<span style="color:red">Not found</span> message and try to figure out why 
there is a mis-match.  In the above example, 
since the sample implementation uses 42 as the correct answer and the autograder
was expecting 46 to be the correct answer, when the autograder tried 45, the application
indicated that the guess was too high which it was actually lower than 46.
</p>
<p>
You can run the autograder as many times as you like to work through the autograder
complaints and fix the errors in your program.
<hr/>
<p>
Provided by: <a href="http://www.wa4e.com/" target="_blank">
www.wa4e.com</a> <br/>
</p>
<center>
Copyright Creative Commons Attribution 3.0 - Charles R. Severance
</center>
</body>
</html>
