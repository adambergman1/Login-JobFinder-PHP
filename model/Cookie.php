<?php

namespace login\model;

// class Cookie {
//   private static $COOKIE_NAME = "LoginView::CookieName";
//   private static $COOKIE_PWD = "LoginView::CookiePassword";
//   private $encodedPassword;
  
//   public function setCookie (string $username, string $password) {
//     $password = $this->encodePassword($password);

//     setcookie(self::$COOKIE_NAME, $username, time() + 1800);
//     setcookie(self::$COOKIE_PWD, $password, time() + 1800);
//   }

//   public function removeCookie () {
//     setcookie(self::$COOKIE_NAME, "", time() - 1800);
//     setcookie(self::$COOKIE_PWD, "", time() - 1800);
//   }

//   public function hasCookie () : bool {
//     return isset($_COOKIE[self::$COOKIE_NAME]) && isset($_COOKIE[self::$COOKIE_PWD]);
//   }

//   public function getUserCredentialsByCookie () : \login\model\UserCredentials {
//     $username = new \login\model\Username($_COOKIE[self::$COOKIE_NAME]);
//     $pass = new \login\model\Password($_COOKIE[self::$COOKIE_PWD]);

//     return new \login\model\UserCredentials($username, $pass, true);
//   }

//   public function encodePassword (string $password) : string {
//     $this->encodedPassword = base64_encode($password);
//     return $this->encodedPassword;
//   }

//   public function decodePassword (string $password) : string {
//     return base64_decode($password);
//   }
// }