<?php

try {
    $pdo = new PDO("mysql:host=localhost;dbname=test", 'root', '');
    echo "It's working";
} catch (PDOException $e) {
    echo $e->getMessage();
}

$del = $pdo->prepare("DELETE FROM burg");
$del->execute();
print_r($del);
