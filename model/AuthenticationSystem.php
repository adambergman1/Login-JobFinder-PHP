<?php

namespace login\model;

require_once('Exceptions.php');

class AuthenticationSystem {
    // private $loggedInUser;
    private $storage;

    public function __construct (\login\model\UserStorage $storage) {
        $this->storage = $storage;
    }

    public function tryToLogin (\login\model\UserCredentials $userCredentials) {
        $username = $userCredentials->getUsername()->getUsername();
        $password = $userCredentials->getPassword()->getPassword();

        $db = new \login\model\Database();
        $db->connect();

        $isAuthenticated = $db->isUserValid($username, $password);

        if ($isAuthenticated) {
            $this->storage->saveUser($username);
            return true;
        } else {
            throw new WrongNameOrPassword;
        }
    }

    public function tryToRegister (\login\model\NewUser $newUser) {
        $username = $newUser->getUsername()->getUsername();
        $password = $newUser->getPassword()->getPassword();

        $db = new \login\model\Database();
        $db->connect();

        if ($db->doesUserExist($username)) {
            throw new UserAlreadyExists;
        } else {
            $db->registerUser($username, $password);
            $this->storage->saveNameFromRegistration($username);
            return true;
        }
    }


    // NOT NEEDED FOR THE MOMENT:
    
    // public function isUserLoggedIn () {
    //     return $this->isLoggedIn;
    // }

    // public function getLoggedInUser () {
    //     return $this->loggedInUser;
    // }

    // public function setLoggedInUser (string $username) {
    //     $savedUser = $this->storage->saveUser($username);
    //     $this->loggedInUser = $savedUser;
    // }

}
