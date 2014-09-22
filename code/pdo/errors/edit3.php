<?php
require_once "db.php";
session_start();

if ( isset($_POST['name']) && isset($_POST['email']) 
     && isset($_POST['password']) && isset($_POST['id']) ) {
    $sql = "UPDATE users SET name = :name, 
            email = :email, password = :password
            WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':name' => $_POST['name'],
        ':email' => $_POST['email'],
        ':password' => $_POST['password'],
        ':id' => $_POST['id'])); 
    $_SESSION['success'] = 'Record updated';
    header( 'Location: index.php' ) ;
    return;
}

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
    $stmt = $pdo->prepare("SELECT * FROM users where id = :xyz");
    $stmt->execute(array(":pizza" => $_GET['id']));
} catch (Exception $ex ) {
    $_SESSION['error'] = $ex->getMessage();
    header( 'Location: index.php' ) ;
    return;
}
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for id';
    header( 'Location: index.php' ) ;
    return;
}

$n = htmlentities($row['name']);
$e = htmlentities($row['email']);
$p = htmlentities($row['password']);
$id = htmlentities($row['id']);

echo <<< _END
<p>Edit User</p>
<form method="post">
<p>Name:
<input type="text" name="name" value="$n"></p>
<p>Email:
<input type="text" name="email" value="$e"></p>
<p>Password:
<input type="text" name="password" value="$p"></p>
<input type="hidden" name="id" value="$id">
<p><input type="submit" value="Update"/>
<a href="index.php">Cancel</a></p>
</form>
_END
?>

