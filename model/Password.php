<?php

namespace login\model;

require_once('Exceptions.php');

class Password {
  private $password;
  private static $MIN_PASSWORD_LENGTH = 8;

  public function __construct(string $password) {
    if ($this->hasInvalidLength($password)) {
      throw new TooShortException("Password has too few characaters, at least " . self::$MIN_PASSWORD_LENGTH . " characters");
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
