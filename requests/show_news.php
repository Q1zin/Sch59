<?php

include '../config.php';

$main_base = new DataBase(BASE_NAME, BASE_USER, BASE_PASS, CHARSET, BASE_HOST);
$news = new GetNews($main_base);

if (isset($_POST['id'])) {
  $art = $_POST['id'];
  $result = $news->get_art($art);
  if (!$result['error'] && $result['content'] != "" && $result['content'] != NULL) {
    $content = $result['content'];
    echo json_encode(array("error" => false, "content" => $content));
    exit;
  }
}
echo json_encode(array("error" => true));
