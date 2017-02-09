<?php
    if ( isset($_POST['where']) ) {
        if ( $_POST['where'] == '1' ) {
            header("Location: redir1.php");
            return;
        } else if ( $_POST['where'] == '2' ) {
            header("Location: redir2.php?parm=123");
            return;
        } else {
            header("Location: http://www.dr-chuck.com");
            return;
        }
    }
?>
<html>
<body style="font-family: sans-serif;">
<p>I am Router One...</p>
<form method="post">
   <p><label for="inp9">Where to go? (1-3)</label>
   <input type="text" name="where" id="inp9" size="5"></p>
   <input type="submit"/>
</form>
</body>
