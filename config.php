<?php

define('BASE_HOST', 'localhost');
define('BASE_NAME', 'school_site');
define('BASE_USER', 'root2');
define('BASE_PASS', 'root');
define('CHARSET', 'utf8');
define('SITE_HOST', $_SERVER['HTTP_HOST']);

session_start();

function add_error_log($message)
{
  $file = fopen('logs_errors.txt', 'a+');
  fwrite($file, date("Y-m-d H:i:s") . " (МСК) - " . $message . "\r\n");
  fclose($file);
}

class User
{
  private $id;
  private $name;
  private $login;
  private $hash;
  private $status;
  private $login_check;

  function __construct($obg_bd)
  {
    if (isset($_SESSION['id']) && isset($_SESSION['login']) && isset($_SESSION['hash'])) {
      $id = $_SESSION['id'];
      $login = $_SESSION['login'];
      $hash = $_SESSION['hash'];

      $result = $obg_bd->db_query_prepare("SELECT `id`, `name`, `login`, `hash`, `status` FROM `users` WHERE `id` = ? AND `login` = ? AND `hash` = ?", [$id, $login, $hash]);
      if (!empty($result)) {
        $result = $result[0];
        $this->id = $result['id'];
        $this->name = $result['name'];
        $this->login = $result['login'];
        $this->hash = $result['hash'];
        $this->status = $result['status'];
        $this->login_check = true;
      } else {
        $this->login_check = false;
        unset($_SESSION['id']);
        unset($_SESSION['login']);
        unset($_SESSION['hash']);
      }
    } else {
      $this->login_check = false;
      unset($_SESSION['id']);
      unset($_SESSION['login']);
      unset($_SESSION['hash']);
    }
  }

  public function get_login_check()
  {
    return $this->login_check;
  }

  public function get_chack_status()
  {
    return $this->status;
  }
  public function get_user_name()
  {
    return $this->name;
  }
}


class DataBase
{
  public $db;
  public $bd_init = false;

  function __construct($bd_name, $login, $password, $charset = 'utf8', $host = 'localhost')
  {
    try {
      $this->db = new PDO("mysql:host=" . $host . ";dbname=" . $bd_name . ";charset=" . $charset, $login, $password, [
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
      ]);
      $this->bd_init = true;
    } catch (PDOException $error) {
      add_error_log("Не удалось подключиться к БД \"" . "mysql:host=$host;dbname=$bd_name;charset=$charset;login=$login;password:$password" . "\" ::: " . $error->getMessage());
    }
  }

  public function db_query($sql = '', $exec = false)
  {
    /*
    $exec = false -> ИЩЕТ что-то в БД и выводит в массиве
    $exec = true -> ВНОСИТ/ИЗМЕНЯЕТ что-то в БД и выводит кол-во затронутых строк
    */

    if (!$this->bd_init) {
      add_error_log("Запрос не прошёл, тк не удалось подключиться к БД");
      return false;
    }

    if (empty($sql) || !isset($sql)) {
      add_error_log("Запрос не прошёл, тк запрос \"$sql\" пуст");
      return false;
    }

    $this->db->beginTransaction();

    if ($exec) {
      try {
        $result = $this->db->exec($sql);
        $this->db->commit();
        return $result;
      } catch (PDOException $error) {
        $this->db->rollBack();
        add_error_log("Ошибка ::: " . $error->getMessage() . " Описание ошибки ::: " .
          "errorInfo()[0] : " . $this->db->errorInfo()[0] .
          " errorInfo()[1] : " . $this->db->errorInfo()[1] .
          " errorInfo()[2] : " . $this->db->errorInfo()[2]);
        return false;
      }
    }

    try {
      $result = $this->db->query($sql);
      $this->db->commit();
      return $result->fetchAll();
    } catch (PDOException $error) {
      $this->db->rollBack();
      add_error_log("Ошибка ::: " . $error->getMessage() . " Описание ошибки ::: " .
        "errorInfo()[0] : " . $this->db->errorInfo()[0] .
        " errorInfo()[1] : " . $this->db->errorInfo()[1] .
        " errorInfo()[2] : " . $this->db->errorInfo()[2]);
      return false;
    }
  }

  public function db_query_prepare($sql = '', $params = [], $exec = false)
  {
    /*
    $exec = false -> ИЩЕТ что-то в БД и выводит в массиве
    $exec = true -> ВНОСИТ/ИЗМЕНЯЕТ что-то в БД и выводит кол-во затронутых строк
    */

    if (!$this->bd_init) {
      add_error_log("Запрос не прошёл, тк не удалось подключиться к БД");
      return false;
    }

    if (empty($sql) || !isset($sql)) {
      add_error_log("Запрос не прошёл, тк запрос: \"$sql\", пуст");
      return false;
    }

    if (empty($params) || !isset($params)) {
      add_error_log("Запрос не прошёл, тк параметры пустые: \"$params\"");
      return false;
    }

    if (gettype($params) != "array") {
      $params = array($params);
    }

    $this->db->beginTransaction();

    if ($exec) {
      try {
        $result = $this->db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $result->execute($params);
        $this->db->commit();
        return $result->rowCount();
      } catch (PDOException $error) {
        $this->db->rollBack();
        add_error_log("Ошибка ::: " . $error->getMessage() . " Описание ошибки ::: " .
          "errorInfo()[0] : " . $this->db->errorInfo()[0] .
          " errorInfo()[1] : " . $this->db->errorInfo()[1] .
          " errorInfo()[2] : " . $this->db->errorInfo()[2]);
        return false;
      }
    }

    try {
      $result = $this->db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
      $result->execute($params);
      $this->db->commit();
      return $result->fetchAll();
    } catch (PDOException $error) {
      $this->db->rollBack();
      add_error_log("Ошибка ::: " . $error->getMessage() . " Описание ошибки ::: " .
        "errorInfo()[0] : " . $this->db->errorInfo()[0] .
        " errorInfo()[1] : " . $this->db->errorInfo()[1] .
        " errorInfo()[2] : " . $this->db->errorInfo()[2]);
      return false;
    }
  }

  // function __destruct()
  // {
  //   $this->db = null;
  // }
}

class GetContentAbout
{
  private $db;
  private $admin_check;


  function __construct($db, $admin_check)
  {
    $this->db = $db;
    $this->admin_check = $admin_check;
  }

  public function get_content($name_page)
  {
    $unique_query = $this->db->db_query("SELECT COUNT(*) AS `Строки`, `for_block` FROM `content_about` GROUP BY `for_block` ORDER BY `for_block`");
    $unique = [];
    foreach ($unique_query as &$value) {
      array_push($unique, $value['for_block']);
    }

    if (in_array($name_page, $unique)) {
      $content_query = $this->db->db_query_prepare("SELECT `id`, `for_block`, `type`, `title`, `check_abs_link`, `link`, `type_link`, `content`, `prioritiy` FROM `content_about` WHERE `for_block` = ?", [$name_page]);
      // Добавить сортировку по приоритету

      if ($this->admin_check->get_login_check()) {
        return $this->sort_content_admin($content_query);
      } else {
        return $this->sort_content($content_query);
      }
    } else {
      return "Ошибка";
      add_error_log('Ошибка!!! при поиске контена во вкладке "sveden" ::: ' . $name_page);
    }
  }

  private function sort_content($get_content)
  {
    // Добавить разбив по блокам (типу)
    $content = "";
    foreach ($get_content as &$value) {
      $content .= "<div class=\"doc-wrap\">
      <img src=\"https://" . SITE_HOST . "/img/service/" . $value['type_link'] . ".svg\" alt=\"icon: " . $value['type_link'] . "\" class=\"document-link__img\">
      <a target=\"_blank\" class=\"link document-link doc-word\" href=" . $value['link'] . ">" . $value['title'] . "</a></div>";
    }

    return $content;
  }
  private function sort_content_admin($get_content)
  {
    // Добавить разбив по блокам (типу)
    $content = "admin ";
    foreach ($get_content as &$value) {
      $content .= "<div class=\"doc-wrap\">
      <img src=\"https://" . SITE_HOST . "/img/service/" . $value['type_link'] . ".svg\" alt=\"icon: " . $value['type_link'] . "\" class=\"document-link__img\">
      <a target=\"_blank\" class=\"link document-link doc-word\" href=" . $value['link'] . ">" . $value['title'] . "</a></div>";
    }

    return $content;
  }
}


$main_base = new DataBase(BASE_NAME, BASE_USER, BASE_PASS, CHARSET, BASE_HOST);

$user = new User($main_base);

$content = new GetContentAbout($main_base, $user);
