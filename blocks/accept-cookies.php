<?php

if (!isset($_COOKIE['accept-cookie'])) {

?>
  <div class="accept-cookie" id="accept-cookie">
    <a href="#" class="accept-cookie__close">
      <img src="../img/service/close-modal.svg" class="accept-cookie__close--img">
    </a>
    <div class="accept-cookie-wrap">
      <p class="accept-cookie__text">Находясь на сайте вы даёте согласие на обработку файлов cookie. Это необходимо для более стабильной работы сайта</p>
      <button class="accept-cookie__btn">Понятно</button>
    </div>
  </div>
<?php } ?>