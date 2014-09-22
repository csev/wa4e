<?php
require_once "pdo.php";

// GET Parameter id=1

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $pdo->prepare("SELECT * FROM users where id = :xyz");
$stmt->execute(array(":pizza" => $_GET['id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    echo("<p>id not found</p>\n");
} else {
    echo("<p>id found</p>\n");
}
?>

