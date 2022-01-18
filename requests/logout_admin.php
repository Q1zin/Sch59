<?php

include '../config.php';

$main_base = new DataBase(BASE_NAME, BASE_USER, BASE_PASS, CHARSET, BASE_HOST);

$id = $_SESSION['id'];

$sql = "UPDATE `users` SET `hash`=Null WHERE `id` = '$id'";

$result = $main_base->query($sql, true);

if (empty($result)) {
  echo json_encode(array("error" => true));
  exit;

  $_SESSION['id'] = null;
  $_SESSION['login'] = null;
  $_SESSION['hash'] = null;
}

echo json_encode(array("error" => false));
exit;
