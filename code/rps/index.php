<?php // Do not put any HTML above this line

// session_start() and header() fail if any (even one
// character) of output has been sent.
session_start();
unset($_SESSION['name']);

$salt = 'XyZzy12*_';
$stored_hash = 'a8609e8d62c043243c4e201cbb342862';  // Pw is meow123

$failure = false;  // If we have no POST data

// Check to see if we have some POST data, if we do process it
if ( isset($_POST['who']) && isset($_POST['pass']) ) {
    if ( strlen($_POST['who']) < 1 || strlen($_POST['pass']) < 1 ) {
        $failure = "User name and password are required";
    } else {
        $check = hash('md5', $salt.$_POST['pass']);
        if ( $check == $stored_hash ) {
            $_SESSION['name'] = $_POST['who'];
            // Redirect the browser to game.php
            header("Location: game.php");
            exit();
        } else {
            $failure = "Incorrect password";
        }
    }
}

// Fall through into the View 
?>
<!DOCTYPE html>
<html>
<head>
<title>Chuck Severance's Login Page</title>
</head>
<body style="font-family: sans-serif;">
<h1>Please Log In</h1>
<?php
// Note triple not equals and think how badly double
// not equals would work here...
if ( $failure !== false ) { 
    // Look closely at the use of single and double quotes
    echo('<p style="color: red;">'.htmlentities($failure)."</p>\n");
}
?>
<form method="POST" action="index.php">
<label for="nam">User Name</label>
<input type="text" name="who" id="nam"><br/>
<label for="id_1723">Password</label>
<input type="text" name="pass" id="id_1723"><br/>
<input type="submit" value="Log In">
</form>
<p>
For a password hint, view source and find a password hint 
in the HTML comments.
<!-- Hint: The password is the four character sound a cat 
makes (all lower case) followed by 123. -->
</p>
<ul>
<li> Try to <a href="game.php">play the game</a> without
logging in.</li>
<li><a href="https://github.com/csev/php-intro/tree/master/code/rps"
target="_blank">Source Code</a></li>
<ul>
</body>
