<!DOCTYPE html>
<?php
require_once("../assn_util.php");
$json = loadPeer("peer.json");
?>
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
<h1>Resources</h1>
<p>There are several resources you might find useful:
<ul>
<li>Recorded lectures, sample code and chapters from the textbook
<a href="http://www.wa4e.com" target="_blank">www.wa4e.com</a>
will be helpful in understanding the aspects of PHP used in this application.
<ul>
<li>Arrays</li>
<li>Functions</li>
<li>Forms and POST Data</li>
</ul>
</li>
<li>Documentation of 
<a href="http://en.wikipedia.org/wiki/Salt_%28cryptography%29" 
target="_blank">how salted hashes work</a> from Wikipedia.
</li>
<li>Documentation on how one web page
<a href="http://en.wikipedia.org/wiki/URL_redirection#Using_server-side_scripting_for_redirection"
target="_blank">redirects</a> to another in HTTP and PHP.
</li>
<li>Documentation from PHP on how the
<a href="http://php.net/manual/en/function.header.php" 
target="_blank">header()</a> function works.
<li><a href="http://www.ngrok.com/" target="_blank">NGROK</a> - A tool
to create temporary secure tunnels from a local server to the Internet
if you need to submit this to an autograder.
</li>
</ul>
<p>
You can download sample code 
for an <b>incomplete/broken</b> version of this application from:
<pre>
<a href="http://www.wa4e.com/code/rps.zip" target="_blank">http://www.wa4e.com/code/rps.zip</a>
</pre>
You can play with the broken sample code at:
<pre>
<a href="http://www.wa4e.com/code/rps/" target="_blank">http://www.wa4e.com/code/rps/</a>
</pre>
</p>
<?php if ( isset($json->solution) ) { ?>
<h2>Sample solution</h2>
<p>
You can explore a sample solution for this problem at:
<pre>
<a href="<?= $json->solution ?>" target="_blank"><?= $json->solution ?></a>
</pre>
<?php } ?>
<h2>Specifications</h2>
<a href="01-RPS-Index.png" target="_blank">
<img style="margin-left: 10px; float:right;" 
alt="Image of the index page"
width="300px" src="01-RPS-Index.png" border="2"/>
</a>
When you first come to the application (index.php) you are told to go to a 
login screen.
<br clear="all">
</p>
<h2>Requirements for the Login Screen</h2>
<p>
<a href="02-RPS-Login.png" target="_blank">
<img style="margin-left: 10px; float:right;" 
alt="Image of the RPS Application login.php"
width="300px" src="02-RPS-Login.png" border="2"/>
</a>
The <b>login.php</b> should be a login screen should present a field 
for the person's name (name="who") and their password (name="pass").  
Your form should have a button labeled "Log In" that submits the form
data using method="POST" (i.e. these should not be GET parameters).
<br clear="all"/>
</p>
<a href="03-RPS-Login-Bad.png" target="_blank">
<img style="margin-left: 10px; float:right;" 
alt="Image of the RPS Application login screen with an error"
width="300px" src="03-RPS-Login-Bad.png" border="2"/></a>
<p>
The login screen needs to have some error checking on its input
data.  If either the name or the password field is blank, you should put 
up a message of the form:
<pre style="color:red">
User name and password are required
</pre>
If the password is non-blank and incorrect, you should put up a message
of the form:
<pre style="color:red">
Incorrect password
</pre>
If there are errors, you should come back to the login screen (login.php)
and show the error with blank input fields (i.e. don't carry over the
values for name="who" and name="pass" fields from the previous post).
<p>
You are to use a "salted hash" for the password.  The "plaintext" of the 
password is not to be present in your application source code execpt in comments.
For this assignment, we will be using the following values for the salt 
and stored hash:
<pre>
$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';
</pre>
The stored_hash is the MD5 of the salt concatenated with the plaintext
of php123 - which is the password.  This has is computed using the following
PHP:
<pre>
$md5 = hash('md5', 'XyZzy12*_php123');
</pre>
In order to check an incoming password you must concatenate te salt plus 
password together and then run that through the <b>hash()</b> function 
and compare it to the stored_hash.
<p>
If the incoming password, properly hashed matches the stored stored_hash
value, the user's browser is 
<a href="http://en.wikipedia.org/wiki/URL_redirection#Using_server-side_scripting_for_redirection"
 target="_blank">redirected</a>
to the <b>game.php</b> page with the user's name as a GET parameter using:
<pre>
header("Location: game.php?name=".urlencode($_POST['who']));
</pre>
<h2>Specifications of the Game Playing Screen</h2>
<p>
In order to protect the game from being played without the user properly
logging in, the <b>game.php</b> must first check the session to see
if the user's name is set and if the user's name is not set in the session
the <b>game.php</b> must stop immediately using the PHP die() function:
<pre>
die("Name parameter missing");
</pre>
To test, navigate to <b>game.php</b> manually without logging in - it 
should fail with "Name parameter missing".
<p>
<a href="04-RPS-Play-Start.png" target="_blank">
<img style="margin-left: 10px; float:right;" 
alt="Image of the RPS Application Initial Play Screen"
width="300px" src="04-RPS-Play-Start.png" border="2"/>
</a>
If the user is logged in, they should be presented with a drop-down menu
showing the options Rock, Paper, Scissors, and Test as well as buttons 
labeled "Play" and "Logout".
</p>
<p>
If the Logout button is pressed the user should be redirected back to the 
<b>index.php</b> page using:
<pre>
header('Location: index.php');
</pre>
<p>
If the user selects, Rock, Paper, or Scissors and presses "Play", the 
game chooses  random computer throw, and scores the game and 
prits out the result of the game:
<pre>
Your Play=Paper Computer Play=Paper Result=Tie
</pre>
The computation as to whether the user wins, loses, or ties is to 
be done in a function named <b>check()</b> that returns a string
telling the user what happenned:
<pre>
// This function takes as its input the computer and human play
// and returns "Tie", "You Lose", "You Win" depending on play
// where "You" is the human being addressed by the computer
function check($computer, $human) {
    ...
        return "Tie";
    ...
        return "You Win";
    ...
        return "You Lose";
    ...
}
</pre>
</p>
<p>
The "Test" option requires that you write two nested <b>for</b>
loops that tests all combinations of possible human and computer
play combinations:
<pre>
for($c=0;$c<3;$c++) {
    for($h=0;$h<3;$h++) {
        $r = check($c, $h);
        print "Human=$names[$h] Computer=$names[$c] Result=$r\n";
    }
}
</pre>
The <b>$names</b> variable contains the strings "Rock", "Paper", 
and "Scissors" in this example.  The output of this should look
look as follows:
</p>
<p>
<center>
<img src="05-RPS-Test.png" style="width:80%" border="1"/>
</center>
</p>
<p>
This will allow you to make sure that your <b>check()</b> function
properly handles all combinations of the possible plays properly
without having to play for a long time as the computer makes 
random plays.
</p>
<h1>What To Hand In</h1>
<p>
For this assignment you will hand in:
<ol>
<?php
foreach($json->parts as $part ) {
    echo("<li>$part->title</li>\n");
}
?>
</ol>
</p>
<h2>Grading</h2>
<p>
<?= $json->grading ?>
</p>
<p>
<?= pointsDetail($json) ?>
</p>
<h1><em>Optional</em> Challenges</h1>
<p>
<b>This section is entirely <em>optional</em> and is here in case you want to 
explore a bit more deeply and test your code skillz.</b></p>
<p>
Here are some possible improvements:
<ul>
<li>Instead of using a series of if-elseif-else statements in the 
<b>check()</b> function, try to compute the win/lose aspect of the game
with a simple arithmetic computation using remainder operator ( % ) 
</li>
<li>Add some images to the output.  Don't replace the required output
with images - simply add some images to make it prettier.
</li>
</ul>
</p>
<p>
Provided by: <a href="http://www.wa4e.com/" target="_blank">
www.wa4e.com</a> <br/>
</p>
<center>
Copyright Creative Commons Attribution 3.0 - Charles R. Severance
</center>
</body>
</html>
