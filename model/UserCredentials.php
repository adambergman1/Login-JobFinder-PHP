<?php

namespace login\model;

class UserCredentials {
  private $username;
  private $password;
  private $stayLoggedIn;

  public function __construct(string $username, string $password, bool $stayLoggedIn) {
    $this->username = $username;
    $this->password = $password;
    $this->stayLoggedIn = $stayLoggedIn;
  }

  public function getUsername () : string {
    return $this->username;
  }

  public function getPassword () : string {
      return $this->username;
  }

  public function stayLoggedIn () : bool {
      return $this->stayLoggedIn;
  }
}

?>