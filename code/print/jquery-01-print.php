hello.php

<html>
<head>
</head>
<body>
<p>Here is some awesome page content</p>
<script type="text/javascript" src="jquery.min.js">
</script>
<script type="text/javascript">
$(document).ready(function(){ 
  alert("Hello JQuery World!"); 
  window.console && console.log('Hello JQuery..');
});
</script>
</body>
Files from http://www.wa4e.com/code/jquery-01.zip

resize.php

<html>
<head>
</head>
<body>
<p>Here is some awesome page content</p>
<script type="text/javascript" src="jquery.min.js">
</script>
<script type="text/javascript">
$(window).resize(function() {
  window.console && console.log('.resize() called. width='+
    $(window).width()+' height='+$(window).height());
});
</script>
</body>

toggle.php

<html>
<head>
</head>
<body>
<p id="para">Where is the spinner?
  <img id="spinner" src="spinner.gif" height="25" 
      style="vertical-align: middle; display:none;">
</p>
<a href="#" onclick="$('#spinner').toggle();
    return false;">Toggle</a>

<a href="#" onclick="$('#para').css('background-color', 'red');
    return false;">Red</a>

<a href="#" onclick="$('#para').css('background-color', 'green');
    return false;">Green</a>
<script type="text/javascript" src="jquery.min.js">
</script>
</body>

autopost.php

<html>
<head>
</head>
<body>
<p>Change the contents of the text field and 
then tab away from the field
to trigger the change event. Do not use
Enter or the form will get submitted.</p>
<form id="target">
  <input type="text" name="one" value="Hello there" 
     style="vertical-align: middle;"/> 
  <img id="spinner" src="spinner.gif" height="25" 
      style="vertical-align: middle; display:none;">
</form>
<hr/>
<div id="result"></div>
<hr/>
<script type="text/javascript" src="jquery.min.js">
</script>
<script type="text/javascript">
  $('#target').change(function(event) {
    $('#spinner').show();
    var form = $('#target');
    var txt = form.find('input[name="one"]').val();
    window.console && console.log('Sending POST');
    $.post( 'autoecho.php', { 'val': txt },
      function( data ) {
          window.console && console.log(data);
          $('#result').empty().append(data);
          $('#spinner').hide();
      }
    ).error( function() { 
      window.console && console.log('error'); 
	});
  });
</script>
</body>

autoecho.php

<?php
  sleep(5);
  echo('You sent: '.$_POST['val']);

