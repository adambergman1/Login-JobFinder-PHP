<?php

namespace login\model;

class Cookie {

  public function setCookie (string $name, string $value) {
    setcookie($name, $value, time() + 1800);
  }

  public function removeCookie (string $name) {
    setcookie($name, "", time() - 1800);
  }

  public function hasCookie (string $name) : bool {
    return isset($_COOKIE[$name]);
  }

  public function getCookieCredentials (string $name) : string {
    return $_COOKIE[$name];
  }
}