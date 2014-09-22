<?php
echo "<pre>\n";
require_once "db.php";
$stmt = $pdo->query("SELECT * FROM users");
while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
    print_r($row);
}
echo "</pre>\n";
?>
