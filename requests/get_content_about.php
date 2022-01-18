<?php

include '../config.php';

if (!isset($_POST['title']) || empty($_POST['title'])) {
  add_error_log("Ошбика при подргузки контента ::: title, var_dump(\$_POST) = " . var_dump($_POST));
  echo json_encode(array("errors" => true));
}

$main_base = new DataBase(BASE_NAME, BASE_USER, BASE_PASS, CHARSET, BASE_HOST);
$user = new User($main_base);
$content = new GetContentAbout($main_base, $user);

$list_title = $content->get_list_links();
if (!isset($list_title[$_POST['title']]) || empty($list_title[$_POST['title']])) {
  add_error_log("Ошбика при подргузки контента ::: title = " . $_POST['title']);
  echo json_encode(array("errors" => true));
}

$list_title = $list_title[$_POST['title']];
$content_in = $content->get_content($_POST['title']);
echo json_encode(array("title" => $list_title, "content" => $content_in, "errors" => false));
