<?php
$error = false;
$md5 = false;
$pin = "";
if ( isset($_GET['pin']) ) {
    if ( strlen($_GET['pin']) != 4 ) {
        $error = "Input must be exactly four characters";
    } else if ( ! is_numeric($_GET['pin'])) {
        $error = "Input must numeric";
    } else {
        $pin = $_GET['pin'];
        $md5 = hash('md5', $pin);
    }
}
?>
<!DOCTYPE html>
<head><title>Charles Severance PIN Code</title></head>
<body>
<h1>MD5 PIN Maker</h1>
<?php
if ( $error !== false ) {
    print '<p style="color:red">';
    print htmlentities($error);
    print "</p>\n";
}

if ( $md5 !== false ) {
    print "<p>MD5 value: ".htmlentities($md5)."</p>";
}
?>
<form>
<input type="text" name="pin" value="<?= htmlentities($pin) ?>"/>
<input type="submit" value="Compute MD5 for PIN"/>
</form>
<p><a href="makepin.php">Reset</a></p>
<p><a href="index.php">Back to Cracking</a></p>
</body>
</html>
