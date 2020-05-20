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
    $insert = $pdo->prepare("INSERT INTO burg (`name`,`phone`,`email`) VALUES ('$name','$phone','$email');");
    $insert->execute();
    echo '<br>Привет, ' . $name . ' Ваш заказ DarkBeefBurger , стоимостью: 500 руб ' .' Вы зарегистрированы спасибо за Ваш первый заказ <br>';
} elseif (!empty($res)) {
    $query = $pdo->prepare("SELECT * FROM burg WHERE `email` = :email");
    $query->execute([':email' => $email]);
    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    echo '<br> Hello ' . $name . ' Ваш заказ DarkBeefBurger , стоимостью: 500 руб ' . ' Спасибо! Это уже 555 заказ' . '<br>';
} else {
    echo $query->errorInfo();
}
$street = $_POST['street'] ?? '';
$home = $_POST['home'] ?? '';
$part = $_POST['part'] ?? '';
$appt = $_POST['appt'] ?? '';
$floor = $_POST['floor'] ?? '';
$comment = $_POST['comment'] ?? '';
$change = $_POST['change'] ?? 0;
$payment = $_POST['payment'] ?? 0;
$callback = $_POST['callback'] ?? 0;


$queryorder = $pdo->prepare("SELECT * FROM address WHERE `street` = :street AND `home` = :home AND `part` = :part
AND `floor` = :floor AND `appt` = :appt");
$queryorder->execute([':street' => $street, ':home' => $home, ':part' => $part, ':floor' => $floor, ':appt' => $appt]);

$do = $queryorder->fetchAll(PDO::FETCH_ASSOC);

if (empty($do)) {
    $queryorder = $pdo->prepare("INSERT INTO address(`street`,`home`,`part`,`appt`,`floor`,`comment`, `change`,`payment`,`callback`)
VALUES('$street', '$home', '$part', '$appt','$floor','$comment','$change','$payment','$callback') ");
    $queryorder->execute();
    echo '<br> спасибо за ваш заказ, он будет доставлен по адресу '. $street . ' '. $home . ' '. $part. ' '. $appt.
        ' '. $floor ;
} elseif (!empty($do)){
    echo 'Спасибо что снова с нами Ваш заказ будет по указанному адресу'. ' ' . $street . ' '. ' дом '.$home . ' '. $part. ' '. $appt.
        ' '. $floor;
}
else {
    echo $queryorder->errorInfo();
}


$join = $pdo->prepare("SELECT * FROM burg LEFT JOIN address USING (id)");
$join->execute();
$done = $join->fetchAll(PDO::FETCH_ASSOC);
//echo '<pre>';
//print_r($done);
//echo '</pre>';

$file = json_encode($done);



file_put_contents('orders.json',$file);


$newfile = json_decode($file,true);

echo '<pre>';
print_r($newfile);
echo '</pre>';




