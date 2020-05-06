<?php

try {
    $pdo = new PDO("mysql:host=localhost;dbname=test", 'root', '');
    echo "It's working";
} catch (PDOException $e) {
    echo $e->getMessage();
}

$email = $_POST ['email'] ?? '';
$name = $_POST['name'] ?? '';
$phone = $_POST['phone'] ?? '';

    $query = $pdo->prepare("SELECT * FROM burg WHERE `email` = :email");
    $query->execute([':email' => $email]);
    $res = $query->fetchAll(PDO::FETCH_ASSOC);

   if (empty($res)) {
    $insert = $pdo->prepare("INSERT INTO burg (`name`,`telephone`,`email`) VALUES ('$name','$phone','$email');");
    $insert->execute();
    echo '<br>Привет, ' . $name . ' Вы зарегистрированы';
}elseif (!empty($res)){
       $query = $pdo->prepare("SELECT * FROM burg WHERE `email` = :email");
       $query->execute([':email' => $email]);
       $res = $query->fetchAll(PDO::FETCH_ASSOC);
       echo '<br> Hello '. $name . ' вы авторизованы';
   }
