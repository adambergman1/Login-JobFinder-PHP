<?php

namespace login\model;

class NewUser {
  private $username;
  private $password;
  private $passwordRepeat;

  public function __construct(string $username, string $password, string $passwordRepeat) {
    $this->nameAndPasswordIsEmpty($username, $password);
    $this->username = new \login\model\Username($username);

    $this->passwordsMatch($password, $passwordRepeat);
    $this->password = new \login\model\Password($password);
    $this->passwordRepeat = new \login\model\Password($passwordRepeat);
  }

  public function nameAndPasswordIsEmpty ($username, $password) {
    if (empty($username) && empty($password)) {
      throw new NameAndPasswordMissing("Username has too few characters, at least 3 characters. Password has too few characters, at least 6 characters.");
    }
  }

  public function passwordsMatch ($password, $passwordRepeat) {
    if ($password != $passwordRepeat) {
      throw new PasswordsDoNotMatch("Passwords do not match.");
    }
  }

  public function getUsername () {
    return $this->username;
  }

  public function getPassword () {
      return $this->password;
  }

  public function getPasswordRepeat () {
      return $this->passwordRepeat;
  }
}
