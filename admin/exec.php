<?php

include '../config.php';

$_SESSION['id'] = '1';
$_SESSION['hash'] = '123';
$_SESSION['login'] = 'q1zin@mail.ru';

$main_base = new DataBase(BASE_NAME, BASE_USER, BASE_PASS, CHARSET, BASE_HOST);
$user = new User($main_base);

print_r($user);

?>
<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Инициальзация админа</title>
</head>

<body>

</body>

</html>