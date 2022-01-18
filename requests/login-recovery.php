<?php

include '../config.php';

$main_base = new DataBase(BASE_NAME, BASE_USER, BASE_PASS, CHARSET, BASE_HOST);

if (isset($_POST['login'])) {

  $login = $_POST['login'];
  $hashRecovery = md5(random_int(345, 9394526234));

  $sql = "UPDATE `users` SET `recovery`= '$hashRecovery' WHERE `login` = '$login'";

  $result = $main_base->query($sql, true);

  if ($result == 0) {
    echo json_encode(array("error" => true, "existLogin" => true, "connect" => false));
    exit;
  }

  // делайм ftp письмо на почту

  echo json_encode(array("error" => false, "connect" => true));
  exit;
} else {
  echo json_encode(array("error" => true, "initErorr" => true, "connect" => false));
  exit;
}
