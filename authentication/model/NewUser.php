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

  public function nameAndPasswordIsEmpty ($username, $password) : void {
    if (empty($username) && empty($password)) {
      throw new NameAndPasswordMissing;
    }
  }

  public function passwordsMatch ($password, $passwordRepeat) : void {
    if ($password != $passwordRepeat) {
      throw new PasswordsDoNotMatch;
    }
  }

  public function getUsername () : \login\model\Username {
    return $this->username;
  }

  public function getPassword () : \login\model\Password {
      return $this->password;
  }
}
