<div class="container" style="flex-direction: column; align-items: center;">
  <h2>Находится в разработке</h2>
  <a href="/sveden/common">Сведения об образовательной организации</a>
  <br>
  <a href="/error-404">Страница ошибки 404</a>
  <br>
  <a href="/examples">Страница с разными функциями</a>
</div>

<hr>

<div class="news">
  <div class="container news-container">
    <div class="news__menu">
      <a href="#" class="news__menu-item news__menu-item--active" data-title="all">Все</a>
      <a href="#" class="news__menu-item" data-title="impos">#важные</a>
      <a href="#" class="news__menu-item" data-title="administr">#администрация</a>
      <a href="#" class="news__menu-item" data-title="answ">#поздравления</a>
      <a href="#" class="news__menu-item" data-title="schlive">#школьная жизнь</a>
      <a href="#" class="news__menu-item" data-title="art">#статьи</a>
    </div>
    <div class="news-wrap news--active" id="news__all" data-count="<?php echo $news->countAll ?>">
      <?php echo $news->news; ?>
    </div>
    <button class="news__btn-more">Больше новостей</button>
  </div>
</div>