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
    $unique_query = $this->db->db_query("SELECT COUNT(*) AS `Строки`, `for_block` FROM `content_about` GROUP BY `for_block` ORDER BY `for_block`");
    $unique = [];
    foreach ($unique_query as &$value) {
      array_push($unique, $value['for_block']);
    }

    if (in_array($name_page, $unique)) {
      $content_query = $this->db->db_query_prepare("SELECT `id`, `for_block`, `type`, `title`, `check_abs_link`, `link`, `type_link`, `content`, `prioritiy` FROM `content_about` WHERE `for_block` = ? ORDER BY `prioritiy` DESC", $name_page);

      if ($this->admin_check->get_login_check()) {
        return $this->sort_content_admin($content_query);
      } else {
        return $this->sort_content($content_query);
      }
    } else {
      add_error_log('Ошибка!!! при поиске контена во вкладке "sveden" ::: ' . $name_page);
      header("Location: https://" . SITE_HOST . "/error-404");
      exit;
    }
  }

  private function sort_content($get_content)
  {
    // Добавить разбив по блокам (типу)
    $content = "";

    foreach ($get_content as $key => &$value) {
      if ($value['type'] == "link") {
        if ($get_content[$key - 1]['type'] != "link") {
          $content .= "<div class=\"sveden-oo__content--doc sveden-oo__doc\">";
        }
        $content .= "<div class=\"sveden-oo__doc-wrap\">
        
        <a target=\"_blank\" class=\"sveden-oo__doc--link\" href=" . $value['link'] . ">
        <img src=\"https://" . SITE_HOST . "/img/service/" . $value['type_link'] . ".svg\" alt=\"icon: " . $value['type_link'] . "\" class=\"sveden-oo__doc--img\">
        " . $value['title'] . "</a></div>";
        if ($get_content[$key + 1]['type'] != "link") {
          $content .= "</div>";
        }
      } else if ($value['type'] == "text") {
        if ($get_content[$key - 1]['type'] != "text") {
          $content .= "<div class=\"sveden-oo__content--text sveden-oo__text-wrap\">";
        }
        $content .= "<p class=\"sveden-oo__text--item\">" . $value['content'] . "</p>";
        if ($get_content[$key + 1]['type'] != "text") {
          $content .= "</div>";
        }
      }
    }
    return $content;
  }
  private function sort_content_admin($get_content)
  {
    $content = "admin ";

    foreach ($get_content as &$value) {
      if ($value['type'] == "link") {
        $content .= "<div class=\"sveden-oo__content--doc sveden-oo__doc-wrap\">
          <img src=\"https://" . SITE_HOST . "/img/service/" . $value['type_link'] . ".svg\" alt=\"icon: " . $value['type_link'] . "\" class=\"sveden-oo__doc--img\">
          <a target=\"_blank\" class=\"sveden-oo__doc--link\" href=" . $value['link'] . ">" . $value['title'] . "</a>
          </div>";
      } else if ($value['type'] == "text") {
        $content .= "<div class=\"sveden-oo__content--doc sveden-oo__text-wrap\">
          <p class=\"sveden-oo__text--item\">" . $value['content'] . "</p>
        </div>";
      }
    }

    return $content;
  }

  public function get_list_links()
  {
    $list_links = [];
    $list_query = $this->db->db_query('SELECT `name_tag`,`title` FROM `section_about` ORDER BY `priority`');
    foreach ($list_query as &$item_link) {
      $list_links[$item_link['name_tag']] = $item_link['title'];
    }
    return $list_links;
  }

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
    // $list_query = $this->db->db_query('SELECT `name_tag`,`title` FROM `section_about` ORDER BY `priority`');
    // foreach ($list_query as &$item_link) {
    //   // $list_links .= "<li class=\"sveden-oo__links-item\"><a href=\"/sveden/" . $item_link['name_tag'] . "\" class=\"sveden-oo__links-item--a\">" . $item_link['title'] . "</a></li>";
    //   $list_links[$item_link['name_tag']] = $item_link['title'];
    // }
    // return $list_links;
  }
}
