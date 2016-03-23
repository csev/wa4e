<!DOCTYPE html>
<?php
$string = file_get_contents("peer.json");
$json = json_decode($string);
if ( $json === null ) {
    echo("<pre>\n");
    echo("Invalid JSON:\n\n");
    echo($string);
    echo("</pre>\n");
    die("<p>Internal error contact instructor</p>\n");
}
?>
<html>
<head>
<title>Assignment: <?= $json->title ?></title>
<style>
li {padding-top: 0.5em;}
pre {padding-left: 2em;}
</style>
</head>
<body style="margin-left:5%; margin-bottom: 60px; margin-right: 5%; font-family: sans-serif;">
<a href="01-Education.png" target="_blank">
<img src="01-Education.png" style="border: 1px solid black; margin-left: 10px; float: right; width: 350px;">
</a>
<h1>Assignment: <?= $json->title ?></h1>
<p>
In this assignment you will extend our simple resume database 
to support Create, Read, Update, and Delete operations (CRUD) 
into a <b>Education</b> table that has a many-to-one relationship
to our <b>Profile</b> table and a many-to-many relationship
to an <b>Institution</b> table.
</p>
<p>
This assignment will use JQuery to dynamically add and
delete positions and education entries in the add and edit user interface.  
This assigment <b>must</b> use JQuery and <b>must not use</b> getElementById() anywhere 
in its code.  So the JavaScript code from the previous assignment must 
be rewritten using jQuery.
</p>
<p>
This assignment will also feature a 
<a href="https://jqueryui.com/autocomplete/" target="_blank">jQuery auto-complete</a>
field when entering the name of the school.
</p>
<?php if ( isset($json->solution) ) { ?>
<h2>Sample solution</h2>
<p>
You can explore a sample solution for this problem at
<pre>
<a href="<?= $json->solution ?>" target="_blank"><?= $json->solution ?></a>
</pre>
<?php } ?>
<h1>Resources</h1>
<p>There are several resources you might find useful:
<ul>
<li>You might want to refer back to the resources for the 
<a href="../../res-position/spec/index.php" target="_blank">
previous assignment</a>.
</li>
<li>Recorded lectures and slides from 
<a href="http://www.php-intro.com" target="_blank">www.php-intro.com</a>:
<ul>
<li class="toplevel">
JavaScript
</li>
<li>
JQuery
</li>
<li>
JSON
</li>
</ul>
<li>An article from Stack Overflow on
<a href="http://stackoverflow.com/questions/17650776/add-remove-html-inside-div-using-javascript"
target="_blank">Add/Remove HTML Inside a div Using JavaScript</a>
(this time you can look at the jQuery versions of the answers for this assignment)
</li>
<li>
Sample code: 
<a href="http://www.php-intro.com/code/jquery-01.zip"
   target="_blank">JQuery</a>, 
<a href="http://www.php-intro.com/code/json-01.zip"
   target="_blank">JSON</a>, 
<a href="http://www.php-intro.com/code/json-02-chat.zip"
   target="_blank">JSON Chat</a>, 
<a href="http://www.php-intro.com/code/json-03-crud.zip"
   target="_blank">JSON CRUD</a>
</ul>
</li>
</ul>
</p>
<h2 clear="all">Additional Tables Required for the Assignment</h2>
<p>
This assignment will add one more table to the database from the previous 
assignment.  We will create <b>Education</b> and <b>Instutition</b> tables 
and connect them to the <b>Profile</b> table.
</p>
<pre>
CREATE TABLE Institution (
  institution_id INTEGER NOT NULL KEY AUTO_INCREMENT,
  name VARCHAR(255),
  UNIQUE(name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE Education (
  profile_id INTEGER,
  institution_id INTEGER,
  rank INTEGER,
  year INTEGER,

  CONSTRAINT education_ibfk_1
        FOREIGN KEY (profile_id)
        REFERENCES Profile (profile_id)
        ON DELETE CASCADE ON UPDATE CASCADE,

  CONSTRAINT education_ibfk_2
        FOREIGN KEY (institution_id)
        REFERENCES Institution (institution_id)
        ON DELETE CASCADE ON UPDATE CASCADE,

  PRIMARY KEY(profile_id, institution_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
</pre>
You must create the <b>Institution</b> table first so that
the CONSTRAINTS in the <b>Education</b> table work properly.
</p>
<p>
Like in the <b>Position</b> table, the <b>rank</b> column should be 
used to record the order in which the positions are to be displayed.   
Do not use the <b>year</b> as the sort key when viewing the data.
</p>
<p>
You should also pre-insert some University data into the
<b>Institution</b> table as follows:
<pre>
INSERT INTO Institution (name) VALUES ('University of Michigan');
INSERT INTO Institution (name) VALUES ('University of Virginia');
INSERT INTO Institution (name) VALUES ('University of Oxford');
INSERT INTO Institution (name) VALUES ('University of Cambridge');
INSERT INTO Institution (name) VALUES ('Stanford University');
INSERT INTO Institution (name) VALUES ('Duke University');
INSERT INTO Institution (name) VALUES ('Michigan State University');
INSERT INTO Institution (name) VALUES ('Mississippi State University');
INSERT INTO Institution (name) VALUES ('Montana State University');
</pre>
This will allow you to have some university names pop up when
you are typing ahead in the School field.
</p>
<h2 clear="all">JavaScript and CSS Code</h2>
<p>
You should include the JQuery CSS, JavaScript, and jQuery UI JavaScript
in your code at the appropriate points.  You can use these files:
<ul>
<li> <a href="../js/jquery-1.10.2.js">http://www.php-intro.com/assn/res-education/js/jquery-1.10.2.js</a></li>
<li> <a href="../js/jquery-ui-1.11.4.js">http://www.php-intro.com/assn/res-education/js/jquery-ui-1.11.4.js</a></li>
<li> <a href="../css/jquery-ui-1.11.4-ui-lightness.css">http://www.php-intro.com/assn/res-education/css/jquery-ui-1.11.4-ui-lightness.css</a></li>
</ul>
</p>
<h2 clear="all">Type Ahead</h2>
<p>
If you look a the sample implementation, the actual typeahead code
in the browser is pretty simple starting with the text field 
that we want to add the auto-complete to:
<pre>
School: &lt;input type="text" size="80" 
    name="edu_school1" class="school" value="" /&gt;
</pre>
This is a normal input tag to which we have added the "school" class.
We attach typeahead code to this input box using the following 
jQuery code:
<pre>
$('.school').autocomplete({
    source: "school.php"
});
</pre>
This simply says that we want to have autocomplete active for all input tags
with a class of "school" and to call the script <b>school.php</b> with the 
partially typed school name using the following calling sequence (make sure
your are logged in before accessing this URL):
</p>
<p>
<a href="http://www.php-intro.com/assn/res-education/school.php?term=Univer"
 target="_blank">http://www.php-intro.com/assn/res-education/school.php?term=Univer</a>
</p>
<p>
The <b>term</b> is whatever has been typed into the input field so far.  The 
HTTP response from the <b>school.php</b> is a JSON array of items to 
displayed as the autocomplete list:
<pre>
["University of Cambridge","University of Michigan",
"University of Oxford","University of Virginia"]
</pre>
</p>
<center>
<img src="02-Autocomplete.png" width="350px" style="border: 1px solid black;">
</center>
<p>
After error checking and session checking the code to return the list
of universities that match the prefix typed so far looks as follows:
<pre>
$stmt = $pdo-&gt;prepare('SELECT name FROM Institution
    WHERE name LIKE :prefix');
$stmt-&gt;execute(array( ':prefix' =&gt; $_REQUEST['term']."%"));

$retval = array();
while ( $row = $stmt-&gt;fetch(PDO::FETCH_ASSOC) ) {
    $retval[] = $row['name'];
}

echo(json_encode($retval));
</pre>

<h2 clear="all">The Screens for This Assignment</h2>
<p>
We will be extending the user interface of the previous assignment 
to implment this assignment.  All of the requirements from the previous
assignment still hold.   In this section we will talk about the additional
UI requirements.
<li>
<b>add.php</b> You will need to have a section where the user can 
press a "+" button to add up to nine empty education entries.  Each education
entry includes a year (integer) and a school name.
</li>
<li>
<b>view.php</b> Will show all of the education entries in an un-numbered list
and the positions in another un-numbered list.
</li>
<li>
<b>edit.php</b> Will support the addition of new position 
or education entries, the deletion of any or all of the existing 
entries, and the modification of any of the existing entries.   After the "Save" 
is done, the data in the database should match whatever positions
and education entries
were on the screen and in the same order as the positions on the 
screen.
</li>
<li><b>index.php</b> No change needed.  </li>
<li><b>login.php</b> No change needed.  </li>
<li><b>logout.php</b> No change needed. </li>
<li> <b>delete.php</b> No change needed. </li>
</ul>
<p>
If the user goes to an add, edit, or delete script without being logged in, die with a message of "ACCESS DENIED".
</p>
<p>
You might notice that there are several common operations across these files.   You might want to build 
a set of utility functions to avoid copying and pasting the same code over and over across several 
files.
</p>
<h2 clear="all">Data validation</h2>
<p>
In addition to all of the validation requirements from the previous assignment,
you must make sure that for all the positions both the year, 
description and institution name are non-blank and that all years are numeric.
<pre style="color:red">
All fields are required
</pre>
or
<pre style="color:red">
Year must be numeric
</pre>
</p>
<h1>What To Hand In</h1>
<p>
As a reminder, your code must meet all the specifications
(including the general specifications) above.  Just having good screen shots
is not enough - we will look at your code to see if you made coding errors.
For this assignment you will hand in:
<ol>
<?php
foreach($json->parts as $part ) {
    echo("<li>$part->title</li>\n");
}
?>
</ol>
<h2 clear="all">General Specifications</h2>
<p>
Here are some general specifications for this assignment:
<ul>
<li>
You <b>must</b> use the PHP PDO database layer for this assignment.  If you use the 
"mysql_" library routines or "mysqli" routines to access the database, you will
<b>receive a zero on this assignment</b>.
<li>
Your name must be in the title tag of the HTML for all of the pages
for this assignment.
</li>
<li>
All data that comes from the users must be properly escaped
using the <b>htmlentities()</b> function in PHP.  You do not 
need to escape text that is generated by your program.
</li>
<li>
You must follow the POST-Redirect-GET pattern for all POST requests.
This means when your program receives and processes a POST request, 
it must not generate any HTML as the HTTP response to that request.
It must use the "header('Location: ...');" function and either "return"
or "exit();" to send the location header and redirect the browser
to the same or a different page.
</li>
<li>
All error messages must be "flash-style" messages where the message is 
passed from a POST to a GET using the SESSION.
</li>
<li>
Please do not use HTML5 in-browser data 
validation (i.e. type="number") for the fields 
in this assignment as we want to make sure you can properly do server 
side data validation.  And in general, even when you do client-side
data validation, you should stil validate data on the server in case
the user is using a non-HTML5 browser.
</li>
</ul>
<p>
Provided by: <a href="http://www.php-intro.com/" target="_blank">
www.php-intro.com</a> <br/>
</p>
<center>
Copyright Creative Commons Attribution 3.0 - Charles R. Severance
</center>
</body>
</html>
