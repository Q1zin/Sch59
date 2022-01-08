<?php

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

  public function query($sql = '', $exec = false)
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

    if ($exec) {
      try {
        $result = $this->db->exec($sql);
        return $result;
      } catch (PDOException $error) {
        add_error_log("Ошибка ::: " . $error->getMessage() . " Описание ошибки ::: " .
          "errorInfo()[0] : " . $this->db->errorInfo()[0] .
          " errorInfo()[1] : " . $this->db->errorInfo()[1] .
          " errorInfo()[2] : " . $this->db->errorInfo()[2]);
        return false;
      }
    }

    try {
      $result = $this->db->query($sql);
      return $result->fetchAll();
    } catch (PDOException $error) {
      add_error_log("Ошибка ::: " . $error->getMessage() . " Описание ошибки ::: " .
        "errorInfo()[0] : " . $this->db->errorInfo()[0] .
        " errorInfo()[1] : " . $this->db->errorInfo()[1] .
        " errorInfo()[2] : " . $this->db->errorInfo()[2]);
      return false;
    }
  }

  public function query_prepare($sql = '', $params = [], $exec = false)
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

    if ($exec) {
      try {
        $result = $this->db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $result->execute($params);
        return $result->rowCount();
      } catch (PDOException $error) {
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
      return $result->fetchAll();
    } catch (PDOException $error) {
      add_error_log("Ошибка ::: " . $error->getMessage() . " Описание ошибки ::: " .
        "errorInfo()[0] : " . $this->db->errorInfo()[0] .
        " errorInfo()[1] : " . $this->db->errorInfo()[1] .
        " errorInfo()[2] : " . $this->db->errorInfo()[2]);
      return false;
    }
  }
}
