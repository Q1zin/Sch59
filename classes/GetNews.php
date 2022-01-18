<?php

class GetNews
{
  public $db;
  public $news = "";
  public $countAll;

  function __construct($bd_name)
  {
    $this->db = $bd_name;
    $result = $bd_name->query('SELECT `id`,`img`,`title`,`sub_title`,`date`,`tags` FROM `content_news` ORDER BY `date` DESC LIMIT 12');
    $sql2 = "SELECT COUNT(*) FROM `content_news` WHERE 1";
    $result2 = $this->db->query($sql2);
    $news = "";
    foreach ($result as $item) {
      $news .= "<div class=\"news__item\" data-id=\"" . $item['id'] . "\">
        <div class=\"news__item-top\">
          <img loading=\"lazy\" src=\"" . $item['img'] . "\" alt=\"img: news img\" class=\"news__item-img\">
        </div>
        <div class=\"news__item-bottom\">
          <h4 class=\"news__item-title\">" . $item['title'] . "</h4>
          <p class=\"news__item-text\">" . $item['sub_title'] . "</p>
        </div>
        <div class=\"news__item-more\">
          <span class=\"news__item-more-item\">" . $item['date'] . "</span>
          <span class=\"news__item-more-item\">" . $item['tags'] . "</span>
        </div>
      </div>";
    }
    $this->news = $news;
    $this->countAll = $result2[0]["COUNT(*)"];
  }

  public function get_art($id)
  {
    $result = $this->db->query_prepare("SELECT `title`, `sub_title`, `date`, `tags`, `content`, `viewability_rate` FROM `content_news` WHERE `id` = ?", $id);
    if (!empty($result)) {
      $result = $result[0];
    } else {
      return ["error" => true];
    }
    $content = "";
    foreach ($result as $key => $item) {
      $content .= "<p><strong>$key</strong> - $item</p>";
    }

    return ["error" => false, "content" => $content];
  }

  public function get_news($tag, $start = null)
  {
    if ($start == null) {
      $sql = "SELECT `id`,`img`,`title`,`sub_title`,`date`,`tags` FROM `content_news` WHERE `tags`='$tag' ORDER BY `date` DESC LIMIT 12";
      $sql2 = "SELECT COUNT(*) FROM `content_news` WHERE `tags`='$tag'";
      $result2 = $this->db->query($sql2);
    } else {
      if ($tag == "Все") {
        $sql = "SELECT `id`,`img`,`title`,`sub_title`,`date`,`tags` FROM `content_news` WHERE 1 ORDER BY `date` DESC LIMIT $start, 12";
      } else {
        $sql = "SELECT `id`,`img`,`title`,`sub_title`,`date`,`tags` FROM `content_news` WHERE `tags`='$tag' ORDER BY `date` DESC LIMIT $start, 12";
      }
      $result2 = array(-1);
    }

    $result = $this->db->query($sql);

    $news = "";
    foreach ($result as $item) {
      $news .= "<div class=\"news__item\" data-id=\"" . $item['id'] . "\">
        <div class=\"news__item-top\">
          <img loading=\"lazy\" src=\"" . $item['img'] . "\" alt=\"img: news img\" class=\"news__item-img\">
        </div>
        <div class=\"news__item-bottom\">
          <h4 class=\"news__item-title\">" . $item['title'] . "</h4>
          <p class=\"news__item-text\">" . $item['sub_title'] . "</p>
        </div>
        <div class=\"news__item-more\">
          <span class=\"news__item-more-item\">" . $item['date'] . "</span>
          <span class=\"news__item-more-item\">" . $item['tags'] . "</span>
        </div>
      </div>";
    }
    return array("content" => $news, "count" => $result2[0]["COUNT(*)"]);
  }
}
