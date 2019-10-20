<?php

namespace login\model;

class AuthenticationSystem {
    private $storage;
    private $db;

    public function __construct (\login\model\UserStorage $storage) {
        $this->storage = $storage;
        $this->db = new \login\model\Database();
    }

    public function tryToLogin (\login\model\UserCredentials $userCredentials) : void {
        $this->db->connect();

        $username = $userCredentials->getUsername()->getUsername();
        $password = $userCredentials->getPassword()->getPassword();

        $isAuthenticated = $this->db->isValid(\login\model\Database::USERS_TABLE, $username, $password);

        if ($isAuthenticated) {
            $this->storage->saveUser($username);
        } else {
            throw new WrongNameOrPassword;
        }
    }

    // TODO: Fix code duplication.
    // The only difference between tryToLogin & loginWithTemporaryPwd is which DB table to look through
    public function loginWithTemporaryPwd (\login\model\UserCredentials $userCredentials) : void {
        $this->db->connect();

        $name = $userCredentials->getUsername()->getUsername();
        $pass = $userCredentials->getPassword()->getPassword();

        $isAuthenticated = $this->db->isValid(\login\model\Database::COOKIES_TABLE, $name, $pass);

        if ($isAuthenticated) {
            $this->storage->saveUser($name);
        } else {
            throw new WrongNameOrPassword;
        }
    }

    public function updateSavedPwd (\login\model\UserCredentials $credentials) : void {
        $this->db->connect();
        $this->db->saveCookie($credentials->getUsername()->getUsername(), $credentials->getPassword()->getPassword());
    }

    public function tryToRegister (\login\model\NewUser $newUser) : void {
        $username = $newUser->getUsername()->getUsername();
        $password = $newUser->getPassword()->getPassword();

        $this->db->connect();

        if ($this->db->doesUserExist($username)) {
            throw new UserAlreadyExists;
        } else {
            $this->db->registerUser($username, $password);
            $this->storage->saveNameFromRegistration($username);
        }
    }
}
