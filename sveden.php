<?php

include 'config.php';

if ($_SERVER['REQUEST_URI'] == "/sveden" || $_SERVER['REQUEST_URI'] == "/sveden/" || $_SERVER['REQUEST_URI'] == "/sveden.php" || $_SERVER['REQUEST_URI'] == "/sveden.php/") {
  header("Location: https://" . SITE_HOST . "/sveden/common");
  exit;
}

// Нужно сделать это отдельной страницой, чтобы при добавлении нового раздела, оно подгружалось
$list_title = array(
  "common" => "Основные сведения",
  "struct" => "Структура и органы управления",
  "document" => "Документы",
  "education" => "Образование",
  "eduStandarts" => "Образовательные стандарты",
  "employees" => "Руководство. Педагогический состав",
  "objects" => "Материально-техническое обеспечение",
  "grants" => "Стипендии и иные виды материальной поддержки",
  "paidedu" => "Финансово-хозяйственная деятельность",
  "budget" => "Платные образовательные услуги",
  "vacant" => "Вакантные места для приёма",
  "ovz" => "Вакантные места для приёма"
);

$title = $list_title[$content->link_conversion($_SERVER['PATH_INFO'])];

?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Сведения об ОО - <?php echo "<Название>"; ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/styles/style-sveden.css">
  <!-- <script src="scripts/script-about-oo.js" defer></script> -->
</head>

<body>

  <header class="header">
    <div class="container">
      Шапка
    </div>
  </header>
  <div class="sveden-oo">
    <div class="container sveden-oo__container">
      <h2 class="sveden-oo__title">Сведения об образовательной организации</h2>
      <div class="sveden-oo-wrap">
        <nav class="sveden-oo__links">
          <ul class="sveden-oo__links-wrap">
            <li class="sveden-oo__links-item"><a href="/sveden/common" class="sveden-oo__links-item--a">Основные сведения</a></li>
            <li class="sveden-oo__links-item"><a href="/sveden/struct" class="sveden-oo__links-item--a">Структура и органы управления</a></li>
            <li class="sveden-oo__links-item"><a href="/sveden/document" class="sveden-oo__links-item--a">Документы</a></li>
            <li class="sveden-oo__links-item"><a href="/sveden/education" class="sveden-oo__links-item--a">Образование</a></li>
            <li class="sveden-oo__links-item"><a href="/sveden/eduStandarts" class="sveden-oo__links-item--a">Образовательные стандарты</a></li>
            <li class="sveden-oo__links-item"><a href="/sveden/employees" class="sveden-oo__links-item--a">Руководство. Педагогический состав</a></li>
            <li class="sveden-oo__links-item"><a href="/sveden/objects" class="sveden-oo__links-item--a">Материально-техническое обеспечение</a></li>
            <li class="sveden-oo__links-item"><a href="/sveden/grants" class="sveden-oo__links-item--a">Стипендии и иные виды материальной поддержки</a></li>
            <li class="sveden-oo__links-item"><a href="/sveden/paidedu" class="sveden-oo__links-item--a">Финансово-хозяйственная деятельность</a></li>
            <li class="sveden-oo__links-item"><a href="/sveden/budget" class="sveden-oo__links-item--a">Платные образовательные услуги</a></li>
            <li class="sveden-oo__links-item"><a href="/sveden/vacant" class="sveden-oo__links-item--a">Вакантные места для приёма</a></li>
            <li class="sveden-oo__links-item"><a href="/sveden/ovz" class="sveden-oo__links-item--a">Доступная среда</a></li>
          </ul>
        </nav>
        <main class="sveden-oo__content">
          <h3 class="sveden-oo__content--title"><?php echo $title; ?></h3>
          <?php echo $content->get_content($_SERVER['PATH_INFO']); ?>
        </main>
      </div>
    </div>
  </div>

</body>

</html>