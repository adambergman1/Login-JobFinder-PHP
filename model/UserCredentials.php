<?php

namespace login\model;

class UserCredentials {
  private $username;
  private $password;
  private $stayLoggedIn;
  private $temporaryPwd = "";

  public function __construct(Username $username, Password $password, bool $stayLoggedIn) {
    $this->username = $username;
    $this->password = $password;
    $this->stayLoggedIn = $stayLoggedIn;
  }

  public function getUsername () {
    return $this->username;
  }

  public function getPassword () {
      return $this->password;
  }

  public function stayLoggedIn () : bool {
      return $this->stayLoggedIn;
  }
}
