<!DOCTYPE html>
<html lang="ru">

<head>
  <?php include 'blocks/head.php'; ?>
  <title>Document</title>
  <link rel="stylesheet" href="/styles/admin-styles.css">
  <script src="/scripts/script-admin-demo.js" defer></script>
</head>

<body>

  <?php
  include 'blocks/header.php';
  ?>
  <div class="container" style="padding: 20px 0; flex-direction: column; align-items: center;">
    <h3>Модалки для ошибок</h3>
    <button onclick="showMessage('error', 'текст')">show-message__error</button>
    <button onclick="showMessage('success', 'текст')">show-message__success</button>
    <h3>Отчистить куки для модалки с принятием куки</h3>
    <button onclick="document.cookie = 'accept-cookie' +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;'; location.reload()">clear cookie</button>
  </div>

  <?php
  include 'blocks/footer.php';
  include 'blocks/accept-cookies.php';
  ?>



</body>

</html>