<?php

include '../config.php';

$main_base = new DataBase(BASE_NAME, BASE_USER, BASE_PASS, CHARSET, BASE_HOST);
$news = new GetNews($main_base);

if (isset($_POST['tag'])) {
  $tag = $_POST['tag'];
  $result = $news->get_news($tag);

  echo json_encode($result);
  exit;
}
echo json_encode(array("error" => true));
