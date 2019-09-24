<?php

namespace login\model;

require_once('Exceptions.php');

class Username {
  private $username;
  private static $MIN_USERNAME_LENGTH = 3;

  public function __construct(string $username) {
    if ($this->hasInvalidLength($username)) {
      throw new TooShortNameException("Username has too few characters, at least 3 characters.");
    }

    if ($this->hasInvalidCharacters($username)) {
      throw new InvalidCharactersException("The username has invalid characters");
    }

    $this->username = $username;
  }

  public function setUsername (string $username) {
    $this->username = $username;
  }

  public function getUsername () : string {
    return $this->username;
  }

  private function hasInvalidLength (string $username) : bool {
    if (strlen($username) < self::$MIN_USERNAME_LENGTH) {
      return true;
    } else {
      return false;
    }
  }

  private function hasInvalidCharacters(string $username) : bool {
    if ($username !== strip_tags($username) && ($username !== trim($username))) {
      return true;
    } else {
      return false;
    }
  }
}
