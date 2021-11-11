<div class="sveden-oo">
  <div class="container sveden-oo__container">
    <h2 class="sveden-oo__title" id="sveden-oo__title">Сведения об образовательной организации</h2>
    <div class="sveden-oo-wrap">
      <nav class="sveden-oo__links">
        <ul class="sveden-oo__links-wrap">
          <!-- <li class="sveden-oo__links-item"><a href="/sveden/common" class="sveden-oo__links-item--a sveden-oo__links-item--a--active">Основные сведения</a></li>
          <li class="sveden-oo__links-item"><a href="/sveden/struct" class="sveden-oo__links-item--a">Структура и органы управления</a></li> -->
          <?php echo $content->get_links($list_title, $title); ?>
        </ul>
      </nav>
      <main class="sveden-oo__content">
        <div class="sveden-oo__content-wrap <?php echo $title_tag; ?>">
          <h3 class="sveden-oo__content--title"><?php echo $title; ?></h3>
          <?php echo $content->get_content($_SERVER['PATH_INFO']); ?>
        </div>
      </main>
    </div>
  </div>
</div>