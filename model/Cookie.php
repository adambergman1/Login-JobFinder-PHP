<?php

namespace login\model;

class Cookie {
  
  public function setCookie ($username, $password) {
			setcookie("LoginView::CookieName", $username, time() + 1800);
      setcookie("LoginView::CookiePassword", $password, time() + 1800);
  }

  public function removeCookie () {
    setcookie("LoginView::CookieName", "", time() - 1800);
    setcookie("LoginView::CookiePassword", "", time() - 1800);
  }

  public function hasCookie () : bool {
    return isset($_COOKIE["LoginView::CookieName"]) && isset($_COOKIE["LoginView::CookiePassword"]);
  }

  public function getUserCredentialsByCookie () : \login\model\UserCredentials {
    $username = new \login\model\Username($_COOKIE["LoginView::CookieName"]);
    $pass = new \login\model\Password($_COOKIE["LoginView::CookiePassword"]);

    return new \login\model\UserCredentials($username, $pass, true);
  }
}