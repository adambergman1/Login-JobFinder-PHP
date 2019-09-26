<?php

namespace login\model;

require_once('Exceptions.php');

class AuthenticationSystem {
    private $loggedInUser;
    private $storage;
    private $cookie;

    public function __construct (\login\model\UserStorage $storage, \login\model\Cookie $cookie) {
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
            $this->setLoggedInUser($username);
            return true;
        } else {
            throw new WrongNameOrPassword("Wrong name or password");
        }
    }

    public function tryToRegister (\login\model\NewUser $newUser) {
        $username = $newUser->getUsername()->getUsername();
        $password = $newUser->getPassword()->getPassword();

        $db = new \login\model\Database();
        $db->connect();

        if ($db->doesUserExist($username)) {
            throw new UserAlreadyExists("User exists, pick another username.");
        } else {
            $db->registerUser($username, $password);
            $this->storage->saveNameFromRegistration($username);
            return true;
        }
    }

    // public function isUserLoggedIn () {
    //     return $this->isLoggedIn;
    // }

    public function getLoggedInUser () {
        return $this->loggedInUser;
    }

    public function setLoggedInUser (string $username) {
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

