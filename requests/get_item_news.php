<?php

include '../config.php';

$main_base = new DataBase(BASE_NAME, BASE_USER, BASE_PASS, CHARSET, BASE_HOST);
$news = new GetNews($main_base);

if (isset($_POST['tag']) && isset($_POST['start'])) {
  $tag = $_POST['tag'];
  $start = $_POST['start'];
  $result = $news->get_news($tag, $start);

  echo json_encode($result);
  exit;
} else {
  echo json_encode(array("error" => "true1"));
}
echo json_encode(array("error" => "true0"));
