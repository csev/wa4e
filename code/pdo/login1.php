<?php
session_start();
require_once "pdo.php";

// p' OR '1' = '1

if ( isset($_POST['email']) && isset($_POST['password'])  ) {
   echo("<!--\n");
   echo("Handling POST data...\n");
   $e = $_POST['email'];
   $p = $_POST['password'];
   echo("Password: $p\n");

   $sql = "SELECT name FROM users
       WHERE email = '$e'
       AND password = '$p'";

   $stmt = $pdo->query($sql);
   $row = $stmt->fetch(PDO::FETCH_ASSOC);

   var_dump($row);
   echo "-->\n";
   if ( $row === FALSE ) {
      echo "<h1>Login incorrect.</h1>\n";
      unset($_SESSION['name']);
   } else {
      echo "<p>Login success.</p>\n";
      $_SESSION['name'] = $row['name'];
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
