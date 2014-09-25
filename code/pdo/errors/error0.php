<?php
require_once "pdo.php";

// GET Parameter id=1

if ( !isset($_GET['id']) ) die('id=1 GET parameter required');

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

$stmt = $pdo->prepare("SELECT * FROM users where id = :xyz");
$stmt->execute(array(":xyz" => $_GET['id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    echo("<p>id not found</p>\n");
} else {
    echo("<p>id found</p>\n");
}
?>

