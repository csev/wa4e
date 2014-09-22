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
  } else if ( $_GET['guess'] == 0 ) {
    echo("Your guess is not valid");
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
  

