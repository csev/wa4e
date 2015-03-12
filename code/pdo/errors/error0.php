<?php
require_once "pdo.php";

// GET Parameter user_id=1

if ( !isset($_GET['user_id']) ) die('user_id=1 GET parameter required');

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

$stmt = $pdo->prepare("SELECT * FROM users where user_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['user_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    echo("<p>user_id not found</p>\n");
} else {
    echo("<p>user_id found</p>\n");
}
?>

