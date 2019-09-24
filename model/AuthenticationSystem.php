<?php

namespace login\model;

require_once('Exceptions.php');

class AuthenticationSystem {
    private $isLoggedIn;
    private $loggedInUser;
    private $storage;
    private $cookie;

    public function __construct (\login\model\UserStorage $storage, \login\model\Cookie $cookie) {
        // Ta in databasen
        $this->storage = $storage;
        $this->cookie = $cookie;
    }

    public function tryToLogin (\login\model\UserCredentials $userCredentials) {
        $username = $userCredentials->getUsername()->getUsername();
        $password = $userCredentials->getPassword()->getPassword();

        $db = new \login\model\Database();
        $db->connect();

        $isAuthenticated = $db->isUserValid($username, $password);

        if ($isAuthenticated) {
            $userCredentials->stayLoggedIn() && $this->cookie->setCookie($username, $password);
            $this->setLoggedInUser($userCredentials->getUsername());
            $this->isLoggedIn = true;
            return true;
        } else {
            throw new WrongNameOrPassword("Wrong name or password");
        }
    }

    public function getIsUserLoggedIn () : bool {
        return $this->isLoggedIn;
    }

    public function getLoggedInUser () {
        return $this->loggedInUser;
    }

    public function setLoggedInUser ($username) {
        $savedUser = $this->storage->saveUser($username);
        $this->loggedInUser = $savedUser;
    }

}


// Try to login

// Isloggedin?

// Get logged in user

// Pratar med UserList som har en koppling till databasen?

// Kanske har en session handler som kan titta i sessionen på rätt plats

// Börja med session innan databasen

// Hårdkoda in Admin och Password

