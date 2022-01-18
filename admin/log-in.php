<?php

include '../config.php';

$main_base = new DataBase(BASE_NAME, BASE_USER, BASE_PASS, CHARSET, BASE_HOST);
$user = new User($main_base);

// print_r($user);

?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <?php
  include '../blocks/head.php';
  ?>
  <link rel="stylesheet" href="../styles/log-in-admin.css">
  <script src="../scripts/log-in-admin.js" defer></script>
  <title>Вход — админ-панель</title>
</head>

<body style="flex-direction: column">

  <?php
  include '../blocks/log-in-admin.php';
  ?>

</body>

</html>