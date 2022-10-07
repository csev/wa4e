<html>
<head>
<title>Guessing Game for Charles Severance</title>
</head>
<body>
<h1>Welcome to my guessing game</h1>
<p>
<?php
  if ( ! isset($_GET['guess']) ) { 
    echo("Missing guess parameter");
  } else if ( strlen($_GET['guess']) < 1 ) {
    echo("Your guess is too short");
  } else if ( ! is_numeric($_GET['guess']) ) {
    echo("Your guess is not a number");
  } else if ( $_GET['guess'] < 42 ) {
    echo("Your guess is too low");
  } else if ( $_GET['guess'] > 42 ) {
    echo("Your guess is too high");
  } else {
    echo("Congratulations - You are right");
  }
?>
</p>
</body>
</html>
  

