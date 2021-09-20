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
This following is a list of people, and their hashed PIN values. 
<pre>
email                pin   hash_pin
-----                ---   --------
csev@umich.edu       ????  0bd65e799153554726820ca639514029
nabgilby@umich.edu   ????  aa36c88c27650af3b9868b723ae15dfc
pconway@umich.edu    ????  1ca906c1ad59db8f11643829560bab55
font@umich.edu       ????  1d8d70dddf147d2d92a634817f01b239
collemc@umich.edu    ????  acf06cdd9c744f969958e1f085554c8b
...
</pre>
You should be able to easily crack all but one of these these PINs using 
your application.
<p>
The simplest brute force approach generally is done by writing a series of 
nested loops that go through all possible combinations of characters.  
This is one of the reasons that password policies specify that you include 
uppper case, lower case, numbers, and punctuation in passwords is to make
brute force cracking more difficult.  Significantly increasing the 
length of the password to something like 20-30 characters is a very 
good to make brute force cracking more difficult.
</p>
<?php if ( isset($json->solution) ) { ?>
<h2>Sample solution</h2>
<p>
You can explore a sample solution for this problem at
<pre>
<a href="<?= $json->solution ?>" target="_blank"><?= $json->solution ?></a>
</pre>
<?php } ?>
<h2>Resources</h2>
<p>There are several sources of information so you can do the assignment:
<ul>
<li> Chapters 14, 23-28, 31 and 32 from the free textbook
<a href="http://milneopentextbooks.org/the-missing-link-an-introduction-to-web-development-and-programming/"
target="_blank">The Missing Link: An Introduction to Web Development and Programming</a> written by
<a href="http://milneopentextbooks.org/author/mmendez/" target="_blank">Michael Menendez</a>
and published by
<a href="http://milneopentextbooks.org/the-missing-link-an-introduction-to-web-development-and-programming/" 
target="_blank">Open SUNY Textbooks</a>.
<li>Lectures and materials on Expressions, Control Flow, Arrays, Functions, and Forms
<a href="http://www.wa4e.com" target="_blank">www.wa4e.com</a></li>
<li>Partially working sample code.
You can play with this application
at <a href="http://www.wa4e.com/code/crack/" target="_blank">http://www.wa4e.com/code/crack/</a>
and download a ZIP of the code at 
<a href="http://www.wa4e.com/code/crack.zip" target="_blank">http://www.wa4e.com/code/crack.zip</a>.
</ul>
</p>
<h2>Specifications</h2>
<a href="01-Crack-In-Action.png" target="_blank">
<img style="margin-left: 10px; float:right;" 
alt="Image of the crack application with a successful crack"
width="400px" 
src="01-Crack-In-Action.png" border="2"/>
</a>
<p>
Your application will take an MD5 value like 
"81dc9bdb52d04dc20036dbd8313ed055" (the MD5 for the string "1234") 
and check all combinations of four-digit "PIN" numbers to see 
if any of those PINs produce the given hash.
</p>
<p>
You will present the user with a form where they can enter an MD5 
string and request that you reverse-hash the string.  If you can reverse hash
the string, print out the PIN:
<pre>
    PIN: 1234
</pre>
If the string 
does not reverse hash to a four digit number simply put out a message like:
<pre>
    PIN: Not found
</pre>
</p>
<p>
You must check all four-digit combinations.  You must hash the value as a
<strong>string</strong> not as an integer. For example, this shows the right and 
wrong way to check the hash for "1234":
<pre>
    $check = hash('md5', '1234');  // Correct - hashing a string
    $check = hash('md5', 1234);    // Incorrect - hashing an integer
</pre>
</p>
<p>
You should also print out the first 15 attempts to reverse-hash including both
the MD5 value and PIN that you were testing.  You should also print out
the elapsed time for your computation as shown in the sample application.
</p>
<h3>Consistency Details</h3>
<p>
In order to make the assignments more consistent, please follow these technical
guidelines:
<ul>
<li>Put all of your code to do the cracking in your "index.php" so you 
can hand in one file.  You can have other files (like in the sample solution)
that you do not have to hand in.</li>
<li>Name the form field where you pass the MD5 into your application "md5"
<pre>
    &lt;input type="text" name="md5" size="40"&gt;
</pre>
</li>
<li>Use the GET method on your form (i.e. not POST)</li>
</ul>
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
<li>For fun, crack all of the pins at the top of this document and figure
out why each person chose their PIN.</li>
<li> You can crack some but not all more complex hashed values using 
a site like:
<a href="https://crackstation.net/" target="_blank">CrackStation.net</a>.  
For fun, use
this site to crack all the above hash values.
<li>Make your application test a more complex character set like, 
upper case letters, lower case letters, numbers, and common punctuation.</li>
<li>Change the code so when it finds a match, it breaks out of all four 
of the nested loops.  So if the PIN turned out to be 1234 it would only run
that many times.  Hint:  Make a logical variable that you set to true
when you get a match and then as soon as that becomes true, break out of
the outer loops.</li>
<li>Make your program handle longer strings - say six characters.  At some 
point when you increase the number of characters and alphabet, it
will take longer to reverse crack the string.</li>
<li>Change the debug output to print an attempt every 0.1 second  instead 
of only the first 15 attempts.</li>
<li>Super Advanced: Make your program handle variable length 
strings - perhaps looking for a string from 3-7 characters long.  
At some point just making more nested loops produces too much code 
and you should switch to a more complex but compact approach that 
uses a few arrays and a while loop.  But this can be 
tricky to construct and prone to infinite loops if you are not careful.
This is probably best not attempted unless you have some background in
Algorithms and Data Structures.
</li>
</ul>
As your program increases its character length, or tests longer passwords, 
it will start to slow down.  Make sure to run these on your laptop (i.e. 
not on a server).  Many hosted PHP systems prohibit these kinds of 
CPU-intensive tasks on their systems. 
</p>
<p>
At some point you might run into a time out where PHP decides that your code
is running too long and blows up your application.  You can check the variable
<strong>max_execution_time</strong> in your PHPInfo screen to see how 
many seconds PHP will let your code run before aborting it.
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
