<?php

include 'config.php';

$main_base = new DataBase(BASE_NAME, BASE_USER, BASE_PASS, CHARSET, BASE_HOST);
$user = new User($main_base);
$news = new GetNews($main_base);

$open_modal = false;
$content = "";
if (isset($_GET['art'])) {
  $art = $_GET['art'];
  $result = $news->get_art($art);
  if (!$result['error'] && $result['content'] != "" && $result['content'] != NULL) {
    $open_modal = true;
    $content = $result['content'];
  }
}



?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <?php include 'blocks/head.php'; ?>
  <title>Главная страница - МБОУ "СОШ №59"</title>
  <link rel="stylesheet" href="/styles/index.css">
  <script src="/scripts/script-index.js" defer></script>
</head>
<!-- stop-scroll -->

<body class="body <?php if ($open_modal) {
                    echo "stop-scroll";
                  } ?>">
  <div class="news-show" <?php if ($open_modal) {
                            echo "style=\"display: flex;\"";
                          } else {
                            echo "style=\"display: none;\"";
                          } ?>>
    <a href="#" class="news-show__close">
      <img loading="lazy" src="/img/service/close-modal-black.svg" alt="icon: close news modal" class="news-show__close-img">
    </a>
    <div class="news-show-wrap">
      <?php if ($open_modal) {
        echo $content;
      } ?>
    </div>
  </div>
  <?php
  include 'blocks/header.php';
  include 'blocks/news.php';
  include 'blocks/footer.php';
  include 'blocks/accept-cookies.php';
  ?>

</body>

</html>