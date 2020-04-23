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
In this assignment, you will build a copy of the "Music" database covered in lecture.  You will 
populate your database with tracks, artists, albums and genres that are different from the ones used 
in class.  You must include three artists, five albums, and 20 tracks in your data.  
Choose a genre for each track.
Your tables need to be normalized as described in class.
</p><p>
Then you must construct and run some queries on your data and then take screen shots 
of those queries and submit the screen shots as your assignment.
</p>
<h2>Resources</h2>
<p>There are several sources of information so you can do the assignment:
<ul>
<li>Lectures and materials on <i>Database Design</i> from
<a href="http://www.wa4e.com" target="_blank">www.wa4e.com</a></li>
<li> Chapters 38, 40, and 42 from the free textbook
<a href="http://textbooks.opensuny.org/the-missing-link-an-introduction-to-web-development-and-programming/"
target="_blank">The Missing Link: An Introduction to Web Development and Programming</a> written by
<a href="http://textbooks.opensuny.org/author/mmendez/" target="_blank">Michael Menendez</a>
and published by
<a href="http://textbooks.opensuny.org/the-missing-link-an-introduction-to-web-development-and-programming/" 
target="_blank">Open SUNY Textbooks</a>.
</ul>
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
<h2>Sample Screen Shots</h2>
<p>
<center>
<a href="tracks.png" target="_blank">
<img src="tracks.png" width="80%"></a>
</center>
</p>
<p>
<center>
<a href="bigjoin.png" target="_blank">
<img src="bigjoin.png" width="80%"></a>
</center>
</p>
<p>
<center>
<a href="artistgenre.png" target="_blank">
<img src="artistgenre.png" width="80%"></a>
</center>
</p>
<h1><em>Optional</em> Challenges</h1>
<p>
<b>This section is entirely <em>optional</em> and is here in case you want to 
explore a bit more deeply and expand your code skillz. There is nothing
to hand in for this challenge.</b></p>
<p>
Come up with a query using <b>GROUP BY</b> to show the number 
of tracks an Artist has in each Genre.
You do not need to hand in a screen shot of this query.
<center>
<a href="groupby.png" target="_blank">
<img src="groupby.png" width="80%"></a>
</center>
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
