<?php
require_once "pdo.php";

// GET Parameter id=1

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
    $stmt = $pdo->prepare("SELECT * FROM users where id = :xyz");
    $stmt->execute(array(":pizza" => $_GET['id']));
} catch (Exception $ex ) { 
    echo("Exception message: ".$ex->getMessage());
    return;
}

$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    echo("<p>id not found</p>\n");
} else {
    echo("<p>id found</p>\n");
}
?>

