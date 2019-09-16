<?php

namespace login\model;

class LoginModel {
    private $username;
    private $password;
    private $stayLoggedIn;

    public function __construct (string $username, string $password, bool $stayLoggedIn) {
        if (!$username) {
            throw new \Exception("Username is missing");
        }
        if (!$password) {
            throw new \Exception("Password is missing");
        }
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