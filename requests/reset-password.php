<?php

include '../config.php';

if (isset($_POST['password']) && isset($_POST['recovery'])) {
  $main_base = new DataBase(BASE_NAME, BASE_USER, BASE_PASS, CHARSET, BASE_HOST);

  $recovery = $_POST['recovery'];
  $password = $_POST['password'];

  // кодирование пароля

  $sql = "UPDATE `users` SET `password`='$password', `hash`=Null, `recovery`=Null WHERE `recovery` = '$recovery'";
  $result = $main_base->query($sql, true);

  if (empty($result)) {
    echo json_encode(array("error" => true, "correctError" => true, "recovery" => $recovery, "password" => $password));
    exit;
  }
  echo json_encode(array("error" => false, "complite" => true));
  exit;
} else {
  echo json_encode(array("error" => true, "initError" => true));
  exit;
}
