<?php
session_start();
if ( isset($_POST['salt']) && isset($_POST['pass']) ) {
    $plain = $_POST['salt'].$_POST['pass'];
    $md5 = hash('md5', $plain);
    $_SESSION['plain'] = $plain;
    $_SESSION['md5'] = $md5;
    $_SESSION['post'] = $_POST;
    header('Location: hash.php');
    return;
}

$salt = isset($_SESSION['post']['salt']) ? $_SESSION['post']['salt'] : 'XyZzy12*_';
$pass = isset($_SESSION['post']['pass']) ? $_SESSION['post']['pass'] : 'php123';

?>
<h1>Welcome to Salted Password Maker</h1>
<?php
    if ( isset($_SESSION['md5']) ) {
        echo('<p>Plaintext: <span style="color: green;">'.$_SESSION['plain']."</span></p>\n");
        echo('<p>MD5: <span style="color: green;">'.$_SESSION['md5']."</span></p>\n");
    }
    unset($_SESSION['plain']);
    unset($_SESSION['md5']);
    unset($_SESSION['post']);
?>
<p>
<form method="post">
<p>Salt:
<input type="text" size="40" name="salt" value="<?= htmlentities($salt) ?>">
</p>
<p>Password:
<input type="text" size="40" name="pass" value="<?= htmlentities($pass) ?>">
</p>
<p>
<input type="submit" value="Compute Salted MD5 Hash">
</form>
</p>
