<?php
require 'db_connect.php';

$stmt = $pdo->query("SELECT * FROM ivanov_231");
while ($row = $stmt->fetch()) {
    print_r($row);
}
?>