<?php

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

      $result = $obg_bd->query_prepare("SELECT `id`, `name`, `login`, `hash`, `status` FROM `users` WHERE `id` = ? AND `login` = ? AND `hash` = ?", [$id, $login, $hash]);
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
