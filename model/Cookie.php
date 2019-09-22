<?php

namespace login\model;

class Cookie {

  public function setCookie (string $username, string $password) {
			setcookie("username", $username, time() + 1800);
			setcookie("password", $password, time() + 1800);
  }

  public function removeCookie () {
    setcookie("username", "", time() - 1800);
    setcookie("password", "", time() - 1800);
  }

  public function hasCookie () : bool {
    return isset($_COOKIE["username"]) && isset($_COOKIE["password"]);
  }

  public function getUserCredentialsByCookie () : \login\model\UserCredentials {
    $username = new \login\model\Username($_COOKIE["username"]);
    $pass = new \login\model\Password($_COOKIE["password"]);

    return new \login\model\UserCredentials($username, $pass, true);
  }
}