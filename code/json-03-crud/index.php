<?php
require_once "pdo.php";
session_start();
?>
<html>
<head>
<script type="text/javascript" src="jquery.min.js">
</script>
<script type="text/javascript">
// Simple htmlentities leveraging JQuery
function htmlentities(str) {
   return $('<div/>').text(str).html();
}
</script>
</head><body>
<?php
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
if ( isset($_SESSION['success']) ) {
    echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
    unset($_SESSION['success']);
}
?>
<table border="1">
  <tbody id="mytab">
  </tbody>
</table>
<script type="text/javascript">
// Do this *after* the table tag is rendered
$.getJSON('getjson.php', function(data) {
    $("#mytab").empty();
    found = false;
    for (var i = 0; i < data.length; i++) {
        entry = data[i];
        found = true;
        window.console && console.log(data[i].title);
        $("#mytab").append("<tr><td>"+htmlentities(entry.title)+'</td><td>'
              + htmlentities(entry.plays)+'</td><td>'+htmlentities(entry.rating)+"</td><td>\n"
              + '<a href="edit.php?id='+htmlentities(entry.id)+'">Edit</a> / '
              + '<a href="delete.php?id='+htmlentities(entry.id)+'">Delete</a>\n</td></tr>');
    }
    if ( ! found ) $("#mytab").append("<tr><td>No entries found</td></tr>\n");
});
</script>
</head>
<a href="add.php">Add New</a>
