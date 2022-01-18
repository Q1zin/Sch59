<?php

include '../config.php';

if (isset($_GET['hash'])) {
  $main_base = new DataBase(BASE_NAME, BASE_USER, BASE_PASS, CHARSET, BASE_HOST);

  $recovery = $_GET['hash'];
  $sql = "SELECT `id` FROM `users` WHERE `recovery` = '$recovery'";
  $result = $main_base->query($sql);
  if (empty($result)) {
    header("Location: https://" . SITE_HOST . "/");
    exit;
  }
} else {
  header("Location: https://" . SITE_HOST . "/");
  exit;
}

?>


<!DOCTYPE html>
<html lang="ru">

<head>
  <?php
  include '../blocks/head.php';
  ?>
  <link rel="stylesheet" href="../styles/admin-log-in-recovery.css">
  <script src="../scripts/admin-log-in-recovery.js" defer></script>
  <title>Восстановление пароля — админ-панель</title>
</head>

<body>
  <div class="login-warp">
    <div class="log-in-rem">
      <h2 class="log-in-rem__title">Восстановление<br>
        пароля</h2>
      <p class="log-in-rem__text">Введите ваш новый пароль</p>
      <div class="log-in__input-wrap log-in__input-wrap-password">
        <input placeholder="Пароль" type="password" class="log-in__input log-in__input-password log-in__input-password-1">
        <a href="#" class="log-in__input-password-eye log-in__input-password-eye-1">
          <img src="../img/service/eye-close-admin.png" alt="icon: eye for password">
        </a>
      </div>
      <div class="log-in__input-wrap log-in__input-wrap-password">
        <input placeholder="Пароль" type="password" class="log-in__input log-in__input-password log-in__input-password-2">
        <a href="#" class="log-in__input-password-eye log-in__input-password-eye-2">
          <img src="../img/service/eye-close-admin.png" alt="icon: eye for password">
        </a>
        <span class="log-in__input-error"></span>
      </div>
      <button class="log-in-rem__submit">Отправить</button>
    </div>
  </div>
</body>

</html>