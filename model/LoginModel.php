<?php

namespace login\model;

class LoginModel {
    private $userName;
    private $password;
    private $stayLoggedIn;

    public function __construct (string $userName, string $password, bool $stayLoggedIn) {
        if (!$userName) {
            throw new \Exception("Missing username");
        }
        $this->userName = $userName;
        $this->password = $password;
        $this->stayLoggedIn = $stayLoggedIn;
    }

    public function getUserName () : string {
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