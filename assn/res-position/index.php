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
<a href="01-Position.png" target="_blank">
<img src="01-Position.png" style="border: 1px solid black; margin-left: 10px; float: right; width: 350px;">
</a>
<h1>Assignment: <?= $json->title ?></h1>
<p>
In this assignment you will extend our simple resume database 
to support Create, Read, Update, and Delete operations (CRUD) 
into a <b>Position</b> table that has a many-to-one relationship
to our <b>Profile</b> table. 
</p>
<p>
This assignment will use JQuery to dynamically add and
delete positions in the add and edit user interface.  
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
<a href="../../res-profile/index.php" target="_blank">
previous assignment</a>.
</li>
<li>An article from Stack Overflow on
<a href="http://stackoverflow.com/questions/17650776/add-remove-html-inside-div-using-javascript"
target="_blank">Add/Remove HTML Inside a div Using JavaScript</a>
(you can scroll past the JavaScript-only answers and see the jQuery answer at the bottom)
</li>
<li>
The documentation for 
<a href="http://php.net/manual/en/pdo.lastinsertid.php" target="_blank">PDO lastInsertId()</a>
where you can retrieve the most recently assigned primary key as a result of an INSERT
statement.
</li>
<li>Recorded lectures and materials from 
<a href="http://www.wa4e.com" target="_blank">www.wa4e.com</a>:
<ul>
<li class="toplevel">
jQuery
(<a href="http://www.wa4e.com/code/jquery.zip"
   target="_blank">Sample Code</a>)
</li>
</ul>
</li>
</ul>
</p>
<h2 clear="all">Additional Table Required for the Assignment</h2>
<p>
This assignment will add one more table to the database from the previous 
assignment.  We will create a <b>Position</b> table and connect it
to the <b>Profile</b> table with a many-to-one relationship.
</p>
<pre>
CREATE TABLE Position (
  position_id INTEGER NOT NULL KEY AUTO_INCREMENT,
  profile_id INTEGER,
  rank INTEGER,
  year INTEGER,
  description TEXT,

  CONSTRAINT position_ibfk_1
        FOREIGN KEY (profile_id)
        REFERENCES Profile (profile_id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
</pre>
There is no logical key for this table.
</p>
<p>
The <b>rank</b> column should be used to record the order 
in which the positions are to be displayed.   Do not use the 
<b>year</b> as the sort key when viewing the data.
</p>
<h2 clear="all">JavaScript and CSS Code</h2>
<p>
You should include the JQuery CSS, JavaScript, and jQuery UI JavaScript
in your code at the appropriate points.  You can use these files:
<ul>
<li> <a href="http://www.wa4e.com/solutions/res-education/js/jquery-1.10.2.js" target="_blank">http://www.wa4e.com/solutions/res-education/js/jquery-1.10.2.js</a></li>
<li> <a href="http://www.wa4e.com/solutions/res-education/js/jquery-ui-1.11.4.js" target="_blank">http://www.wa4e.com/solutions/res-education/js/jquery-ui-1.11.4.js</a></li>
<li> <a href="http://www.wa4e.com/solutions/res-education/css/jquery-ui-1.11.4-ui-lightness.css" target="_blank">http://www.wa4e.com/solutions/res-education/css/jquery-ui-1.11.4-ui-lightness.css</a></li>
</ul>
</p>
<h2 clear="all">The Screens for This Assignment</h2>
<p>
We will be extending the user interface of the previous assignment 
to implment this assignment.  All of the requirements from the previous
assignment still hold.   In this section we will talk about the additional
UI requirements.
<li>
<b>add.php</b> You will need to have a section where the user can 
press a "+" button to add up to nine empty position entries.  Each position
entry includes a year (integer) and a description.
</li>
<li>
<b>view.php</b> Will show all of the positions in an un-numbered list.
</li>
<li>
<b>edit.php</b> Will support the addition of new position entries, 
the deletion of any or all of the existing entries, and 
the modification of any of the existing entries.   After the "Save" 
is done, the data in the database should match whatever positions
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
you must make sure that for all the positions both the year and 
description are non-blank and that the year is numeric.
<pre style="color:red">
All fields are required
</pre>
or
<pre style="color:red">
Year must be numeric
</pre>
</p>
<h2 clear="all">Handling the Input From Multiple Positions</h2>
<p>
If you look at the sample implementation, it only allows a 
maximum of nine positions in the form.  This is checked 
and enforced in the JavaScript for both the add.php and 
edit.php code.
</p>
<p>
The logic is somewhat simple and gets confused when there is 
a combination of adds and deletes.  It will never add more 
than nine new or total positions, but if you delete some 
of the positions, you do not get a postion "back" to re-add 
unless you press "Save".  So if you 
add eight positions and then delete five positions without 
pressing "Save", you can only add one more entry rather 
than four more entries.
</p>
<p>
This makes the JavaScript simpler and you are welcome to take
the same approach.  
</p>
<p>The result is that if you add two positions and delete one 
position, you will end up with a form that looks like the following
in the generated document object model:
<pre>
&lt;div id="position1"&gt;
&lt;p>Year: &lt;input type="text" name="year1" value=""&gt;
&lt;input type="button" value="-" onclick="$('#position1').remove();return false;"&gt;&lt;/p&gt;
&lt;textarea name="desc1" rows="8" cols="80"&gt;&lt;/textarea&gt;
&lt;/div&gt;
&lt;div id="position3"&gt;
&lt;p&gt;Year: &lt;input type="text" name="year3" value=""&gt;
&lt;input type="button" value="-" onclick="$('#position3').remove();return false;"&gt;&lt;/p&gt;
&lt;textarea name="desc3" rows="8" cols="80"&gt;&lt;/textarea&gt;
&lt;/div&gt;
</pre>
In a sense we are simulating an array with the naming convention of the fields 
with the number at the end of the field.   A way to handle multiple inputs with 
a naming convention like this is to use code like the following:
<pre>
function validatePos() {
    for($i=1; $i<=9; $i++) {
        if ( ! isset($_POST['year'.$i]) ) continue;
        if ( ! isset($_POST['desc'.$i]) ) continue;
        $year = $_POST['year'.$i];
        $desc = $_POST['desc'.$i];
        if ( strlen($year) == 0 || strlen($desc) == 0 ) {
            return "All fields are required";
        }

        if ( ! is_numeric($year) ) {
            return "Position year must be numeric";
        }
    }
    return true;
}
</pre>
Note that we handle gaps by simply checking the data that is present and skipping 
any data that is missing.
</p>
<h1>Setting the Foreign Key for Positions</h1>
<p>
When you are building the <b>add.php</b> code to add a new profile and some 
number of positions, you need to insert the <b>profile_id</b> as a foreign
key for each of the position rows.  But since you have not yet added the profile
you do now know the <b>profile_id</b> which will be selected by the database.
</p>
<p>
Fortunately there is a way to ask PDO for the most recently inserted primary
key after the insert has been done using the <b>lastInsertId()</b> method provided 
by PDO.  Here is some sample code:
<pre>
    // Data is valid - time to insert
    $stmt = $pdo-&gt;prepare('INSERT INTO Profile
        (user_id, first_name, last_name, email, headline, summary) 
    VALUES ( :uid, :fn, :ln, :em, :he, :su)');
    $stmt-&gt;execute(array(
        ':uid' =&gt; $_SESSION['user_id'],
        ':fn' =&gt; $_POST['first_name'],
        ':ln' =&gt; $_POST['last_name'],
        ':em' =&gt; $_POST['email'],
        ':he' =&gt; $_POST['headline'],
        ':su' =&gt; $_POST['summary'])
    );
    $profile_id = $pdo-&gt;lastInsertId();

    ...

        $stmt = $pdo-&gt;prepare('INSERT INTO Position
            (profile_id, rank, year, description) 
        VALUES ( :pid, :rank, :year, :desc)');
        $stmt-&gt;execute(array(
            ':pid' =&gt; $profile_id,
            ':rank' =&gt; $rank,
            ':year' =&gt; $year,
            ':desc' =&gt; $desc)
        );
        $rank++;
</pre>
The variable <b>$profile_id</b> contains the primary key of the newly created profile
so you can include it in the INSERT into the Postion table.
</p>
<h1>Dealing with Changes to Positions When Editing</h1>
<p>
When you implement <b>edit.php</b> the user can do any combination of adds, removals, or edits
of the position data.   So when you are processing the incoming POST data, you need to somehow
get the data in the database to match the incoming POST data.  
</p>
<p>
One (difficult) approach is to retrieve the "old" positions from the database, and loop
through all old positions and figure out which need to be deleted, updated, or inserted.
If you want to try to do that for this assignment - feel free - but consider it an "extra challenge".
</p>
<p>
For your first implementation of handling the POST data in <b>edit.php</b> just delete all
the old Postion entries and re-insert them:
<pre>
    // Clear out the old position entries
    $stmt = $pdo-&gt;prepare('DELETE FROM Position
        WHERE profile_id=:pid');
    $stmt-&gt;execute(array( ':pid' =&gt; $_REQUEST['profile_id']));

    // Insert the position entries
    $rank = 1;
    for($i=1; $i&lt;=9; $i++) {
        if ( ! isset($_POST['year'.$i]) ) continue;
        if ( ! isset($_POST['desc'.$i]) ) continue;
        $year = $_POST['year'.$i];
        $desc = $_POST['desc'.$i];

        $stmt = $pdo-&gt;prepare('INSERT INTO Position
            (profile_id, rank, year, description)
        VALUES ( :pid, :rank, :year, :desc)');
        $stmt-&gt;execute(array(
            ':pid' =&gt; $_REQUEST['profile_id'],
            ':rank' =&gt; $rank,
            ':year' =&gt; $year,
            ':desc' =&gt; $desc)
        );
        $rank++;
    }
</pre>
This approach has the nice advantage that you are reusing code between
<b>edit.php</b> and <b>add.php</b>.  The only difference is that in <b>edit.php</b> you just remove
the existing entries first.


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
<h1><em>Optional</em> Challenges</h1>
<p>
<ul>
<li>Try to so the more inticate approach to updating positions in
<b>edit.php</b> without using the "delete all the previous positions" trick.
It will help if you add the <b>position_id</b> form markup that you 
generate for the positions that came from the database when <b>edit.php</b>
starts.
</ul>
</p>
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
data validation, you should still validate data on the server in case
the user is using a non-HTML5 browser.
</li>
</ul>
<p>
Provided by: <a href="http://www.wa4e.com/" target="_blank">
www.wa4e.com</a> <br/>
</p>
<center>
Copyright Creative Commons Attribution 3.0 - Charles R. Severance
</center>
</body>
</html>
