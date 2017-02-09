<?php
    session_start();
    if ( isset($_POST['guess']) ) {
        $guess = $_POST['guess'] + 0;
        $_SESSION['guess'] = $guess;
        if ( $guess == 42 ) {
            $_SESSION['message'] = "Great job!";
        } else if ( $guess < 42 ) {
            $_SESSION['message'] = "Too low";
        } else  {
            $_SESSION['message'] = "Too high...";
        }
        header("Location: guess2.php");
        return;
    }
?>
<html>
<head><title>A Guessing game</title></head>
<body style="font-family: sans-serif;">
<?php
    $guess = isset($_SESSION['guess']) ? $_SESSION['guess'] : '';
    $message = isset($_SESSION['message']) ? $_SESSION['message'] : false;
?>
<p>Guessing game...</p>
<?php
   if ( $message !== false )  {
        echo("<p>$message</p>\n");
    }
?>
<form method="post">
   <p><label for="guess">Input Guess</label>
   <input type="text" name="guess" id="guess" size="40"
<?php
   echo 'value="' . htmlentities($guess) . '"';
?>
   /></p>
   <input type="submit"/>
</form>
</body>
