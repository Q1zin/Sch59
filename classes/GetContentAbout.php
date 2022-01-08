<?php

class GetContentAbout
{
  private $db;
  private $admin_check;


  function __construct($db, $admin_check)
  {
    $this->db = $db;
    $this->admin_check = $admin_check;
  }

  public function link_conversion($path_name)
  {
    return str_replace(array("/", "\\"), "", $path_name);
  }

  public function get_content($name_page)
  {
    $name_page = $this->link_conversion($name_page);
    $unique_query = $this->db->query("SELECT COUNT(*) AS `Строки`, `for_block` FROM `content_about` GROUP BY `for_block` ORDER BY `for_block`");
    $unique = [];
    foreach ($unique_query as &$value) {
      array_push($unique, $value['for_block']);
    }

    if (in_array($name_page, $unique)) {
      $content_query = $this->db->query_prepare("SELECT `content` FROM `content_about` WHERE `for_block` = ?", $name_page);

      return $content_query[0]["content"];
    } else {
      add_error_log('Ошибка!!! при поиске контена во вкладке "sveden" ::: ' . $name_page);
      header("Location: https://" . SITE_HOST . "/error-404");
      exit;
    }
  }

  public function get_list_links()
  {
    $list_links = [];
    $list_query = $this->db->query('SELECT `name_tag`,`title` FROM `section_about` ORDER BY `priority`');
    foreach ($list_query as &$item_link) {
      $list_links[$item_link['name_tag']] = $item_link['title'];
    }
    return $list_links;
  }

  // Возвращает список ссылок, как html элемент
  public function get_links($list_links, $opened_link)
  {
    $links = "";
    foreach ($list_links as $name_tag => $title) {
      if ($opened_link == $title) {
        $links .= "<li class=\"sveden-oo__links-item\"><a href=\"/sveden/" . $name_tag . "\" class=\"sveden-oo__links-item--a sveden-oo__links-item--a--active\">" . $title . "</a></li>";
      } else {
        $links .= "<li class=\"sveden-oo__links-item\"><a href=\"/sveden/" . $name_tag . "\" class=\"sveden-oo__links-item--a\">" . $title . "</a></li>";
      }
    }
    return $links;

    // $list_links = "a";
    // $list_query = $this->db->query('SELECT `name_tag`,`title` FROM `section_about` ORDER BY `priority`');
    // foreach ($list_query as &$item_link) {
    //   // $list_links .= "<li class=\"sveden-oo__links-item\"><a href=\"/sveden/" . $item_link['name_tag'] . "\" class=\"sveden-oo__links-item--a\">" . $item_link['title'] . "</a></li>";
    //   $list_links[$item_link['name_tag']] = $item_link['title'];
    // }
    // return $list_links;
  }
}
