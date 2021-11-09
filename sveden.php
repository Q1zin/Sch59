<?php

include 'config.php';

// $result = $main_base->db_query("INSERT INTO `users`(`name`, `login`, `password`, `status`) VALUES ('1','2','3','4')", true);
// print_r($result);
// echo "<hr />";
// $result = $main_base->db_query_prepare("INSERT INTO `users`(`name`, `login`, `password`, `status`) VALUES (?,?,?,?)", ['1', '2', '3', '4'], true);
// print_r($result);
// echo "<hr />";
// $result = $main_base->db_query_prepare("SELECT * FROM `users` WHERE ?", 1);
// var_dump($result);
// echo "<hr />";
// $result = $main_base->db_query("SELECT * FROM `users` WHERE 1");
// var_dump($result);
// echo "<hr />";



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
  <link rel="stylesheet" href="styles/style-sveden.css">
  <script src="script.js" defer></script>
</head>

<body>

  <header class="header">
    <div class="container">
      Шапка
    </div>
  </header>
  <div class="sveden-oo">
    <div class="container">
      <div class="sveden-oo-wrap">
        <nav class="sveden-oo__links">
          <ul class="sveden-oo__links-wrap">
            <li class="sveden-oo__links-item"><a href="sveden/common" class="sveden-oo__links-item--a">Основные сведения</a></li>
            <li class="sveden-oo__links-item"><a href="sveden/struct" class="sveden-oo__links-item--a">Структура и органы управления</a></li>
            <li class="sveden-oo__links-item"><a href="sveden/document" class="sveden-oo__links-item--a">Документы</a></li>
            <li class="sveden-oo__links-item"><a href="sveden/#" class="sveden-oo__links-item--a">Образование</a></li>
            <li class="sveden-oo__links-item"><a href="sveden/#" class="sveden-oo__links-item--a">Образовательные стандарты</a></li>
            <li class="sveden-oo__links-item"><a href="sveden/#" class="sveden-oo__links-item--a">Руководство. Педагогический состав</a></li>
            <li class="sveden-oo__links-item"><a href="sveden/#" class="sveden-oo__links-item--a">Материально-техническое обеспечение</a></li>
            <li class="sveden-oo__links-item"><a href="sveden/#" class="sveden-oo__links-item--a">Стипендии и иные виды материальной поддержки</a></li>
            <li class="sveden-oo__links-item"><a href="sveden/#" class="sveden-oo__links-item--a">Платные образовательные услуги</a></li>
            <li class="sveden-oo__links-item"><a href="sveden/#" class="sveden-oo__links-item--a">Вакантные места для приёма</a></li>
          </ul>
        </nav>
        <main class="sveden-oo__content">Контент<br /><?php echo $content->get_content('common'); ?></main>
      </div>
    </div>
  </div>

</body>

</html>

<?php

// echo '<pre>';
// var_dump($_GET);
// echo '</pre>';
// echo "<hr />";
// echo "<hr />";
// echo "<hr />";
// echo '<pre>';
// var_dump($_SERVER);
// echo '</pre>';

// phpinfo();

?>