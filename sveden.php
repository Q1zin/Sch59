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
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Сведения об ОО - <?php echo $title; ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Arimo:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&family=Comfortaa:wght@300;400;500;600;700&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/styles/style-sveden.css">
  <link rel="icon" href="/favicon.ico" type="image/png">
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