<?php

namespace login\model;

class Password {
  private $password;
  private static $MIN_PASSWORD_LENGTH = 6;

  public function __construct(string $password) {
    if ($this->hasInvalidLength($password)) {
      throw new TooShortPasswordException;
    }

    $this->password = $password;
  }

  public function setPassword (string $password) {
    $this->password = $password;
  }

  public function getPassword () : string {
    return $this->password;
  }

  private function hasInvalidLength (string $password) : bool {
    if (strlen($password) < self::$MIN_PASSWORD_LENGTH) {
      return true;
    } else {
      return false;
    }
  }
}
