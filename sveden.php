<?php

include 'config.php';

$main_base = new DataBase(BASE_NAME, BASE_USER, BASE_PASS, CHARSET, BASE_HOST);
$user = new User($main_base);
$content = new GetContentAbout($main_base, $user);


if ($_SERVER['REQUEST_URI'] == "/sveden" || $_SERVER['REQUEST_URI'] == "/sveden/" || $_SERVER['REQUEST_URI'] == "/sveden.php" || $_SERVER['REQUEST_URI'] == "/sveden.php/") {
  header("Location: https://" . SITE_HOST . "/sveden/common");
  exit;
}

$list_title = $content->get_list_links();

$title_tag = $content->link_conversion($_SERVER['PATH_INFO']);

$title = $list_title[$title_tag];

?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <?php include 'blocks/head.php'; ?>

  <title>Сведения об ОО - <?php echo $title; ?></title>
  <link rel="stylesheet" href="/styles/style-sveden.css">
  <script src="/scripts/script-about-oo.js" defer></script>
</head>

<body>

  <?php
  include 'blocks/header.php';
  include 'blocks/sveden-oo.php';
  include 'blocks/footer.php';
  ?>

</body>

</html>