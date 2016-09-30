Files from http://www.wa4e.com/code/json-01.zip

syntax.php

<html><head/><body>
<script type="text/javascript">
who = {
    'name': 'Chuck',
    'age': 29, 
    'college': true,
    'offices' : [ '3350DMC', '3437NQ' ],
    'skills' : { 'fortran': 10, 'C': 10, 
        'C++': 5, 'python' : '7' }
};
window.console && console.log(who);
</script>
<p>Check out the console.log to see the cool object</p>
<pre>
who = {
    'name': 'Chuck',
    'age': 29, 
    'college': true,
    'offices' : [ '3350DMC', '3437NQ' ],
    'skills' : { 'fortran': 10, 'C': 10, 
        'C++': 5, 'python' : '7' }
};
</pre>
</body>

json.php

<?php
  sleep(2);
  header('Content-Type: application/json; charset=utf-8');
  $stuff = array('first' => 'first thing', 'second' => 'second thing');
  echo(json_encode($stuff));


index.php 

<html>
<head>
</head>
<body>
<p>Howdy - Lets get some JSON</p>
<p id="back">Original static text</p>
<p>
<a href="syntax.php" target="_new">JSON Syntax</a> |
<a href="json.php" target="_new">json.php</a>
</p>
<script type="text/javascript" src="jquery.min.js">
</script>
<script type="text/javascript">
$(document).ready( function () {
  $.getJSON('json.php', function(data) {
      $("#back").html(data.first);
      window.console && console.log(data);
    })
  }
);
</script>
</body>
