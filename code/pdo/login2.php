<?php
session_start();
$db = mysql_connect("localhost","fred", "zap") or die('Fail message');
mysql_select_db("misc") or die("Fail message");

// p' OR email = 'barb@umich.edu

if ( isset($_POST['email']) && isset($_POST['password'])  ) {
   echo("<!--\n");
   echo("Handling POST data...\n");
   $e = mysql_real_escape_string($_POST['email']);
   $p = mysql_real_escape_string($_POST['password']);

   $sql = "SELECT name FROM users 
       WHERE email = '$e' 
       AND password = '$p'";

   $result = mysql_query($sql);
   $row = mysql_fetch_row($result);	
   var_dump($row);
   echo "-->\n";
   if ( $row === FALSE ) {
      echo "<h1>Login incorrect.</h1>\n";
      unset($_SESSION['name']);
   } else { 
      echo "<p>Login success.</p>\n";
      $_SESSION['name'] = $row[0];
   }
   echo "<pre>\n";
   echo "$sql\n";
   echo "</pre>\n";
}
if ( isset($_SESSION['name']) ) {
   echo('<p>Hello '.htmlentities($_SESSION['name']).'</p>'."\n");
   echo('<p><a href="logout.php">Logout</a></p>'."\n");
   return;
}
?>
<p>Please Login</p>
<form method="post">
<p>Email:
<input type="text" size="40" name="email"></p>
<p>Password:
<input type="text" size="40" name="password"></p>
<p><input type="submit" value="Login"/>
<a href="<?php echo($_SERVER['PHP_SELF']);?>">Refresh</a></p>
</form>
<p>
Check out this 
<a href="http://xkcd.com/327/" target="_blank">XKCD comic that is relevant</a>.
