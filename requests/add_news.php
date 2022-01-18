<?php

if (!isset($_POST['img']) && !isset($_POST['title']) && !isset($_POST['subTitle']) && !isset($_POST['date']) && !isset($_POST['tags']) && !isset($_POST['content'])) {
  echo json_encode(array("error" => true));
  exit;
}

include '../config.php';

$main_base = new DataBase(BASE_NAME, BASE_USER, BASE_PASS, CHARSET, BASE_HOST);
$user = new User($main_base);

if ($user->get_chack_status() != 'admin') {
  echo json_encode(array("error" => true));
  exit;
}

$img = $_POST['img'];
$title = $_POST['title'];
$subTitle = $_POST['subTitle'];
$date = $_POST['date'];
$tags = $_POST['tags'];
$content = $_POST['content'];

$result = $main_base->query('INSERT INTO `content_news` (`img`, `title`, `sub_title`, `date`, `tags`, `content`) VALUES (\'' . $img . '\',\'' . $title . '\',\'' . $subTitle . '\',\'' . $date . '\',\'' . $tags . '\',\'' . $content . "')", true);


if ($result == null) {
  echo json_encode(array("error" => true, "result" => $result));
  exit;
}

echo json_encode(array("error" => false));
