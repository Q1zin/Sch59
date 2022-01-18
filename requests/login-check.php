<?php

include '../config.php';

$main_base = new DataBase(BASE_NAME, BASE_USER, BASE_PASS, CHARSET, BASE_HOST);

if (isset($_POST['login']) && isset($_POST['password'])) {

  $sql = "SELECT `id`, `password` FROM `users` WHERE `login` = '" . $_POST['login'] . "'";

  $result = $main_base->query($sql);

  if (empty($result)) {
    echo json_encode(array("error" => true, "loginErorr" => true, "connect" => false));
    exit;
  }

  // не обычное сравнение, а декод пароля
  if ($_POST['password'] == $result[0]['password']) {
    $hash = md5(random_int(345, 9394526234));
    $id = $result[0]['id'];

    $sql2 = "UPDATE `users` SET `hash`='$hash' WHERE `id` = '$id'";
    $result2 = $main_base->query($sql2, true);

    $_SESSION['id'] = $id;
    $_SESSION['login'] = $_POST['login'];
    $_SESSION['hash'] = $hash;

    echo json_encode(array("error" => false, "connect" => true));
    exit;
  } else {
    echo json_encode(array("error" => true, "passwordErorr" => true, "connect" => false));
    exit;
  }
} else {
  echo json_encode(array("error" => true, "initErorr" => true, "connect" => false));
  exit;
}
