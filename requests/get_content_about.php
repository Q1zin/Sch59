<?php

include '../config.php';

$main_base = new DataBase(BASE_NAME, BASE_USER, BASE_PASS, CHARSET, BASE_HOST);
$user = new User($main_base);
$content = new GetContentAbout($main_base, $user);

$list_title = $content->get_list_links();
$content_in = $content->get_content($_POST['title']);
// 
// 

if (isset($_POST['title'])) {
  echo $list_title[$_POST['title']] . "&^%@" . $content_in;
} else {
  add_error_log("Ошбика при подргузки контента ::: title = " . $_POST['title']);
}
