<?php

namespace login\model;

class AuthenticationSystem {
    private $storage;
    private $db;

    public function __construct (\login\model\UserStorage $storage) {
        $this->storage = $storage;
        $this->db = new \login\model\Database();
    }

    public function tryToLogin (\login\model\UserCredentials $userCredentials) {
        $this->handleDBErrors();
        $this->db->connect();

        $username = $userCredentials->getUsername()->getUsername();
        $password = $userCredentials->getPassword()->getPassword();

        $isAuthenticated = $this->db->isValid(\login\model\Database::USERS_TABLE, $username, $password);

        if ($isAuthenticated) {
            $this->storage->saveUser($username);
            return true; 
        } else {
            throw new WrongNameOrPassword;
        }
    }

    public function loginWithTemporaryPwd (\login\model\UserCredentials $userCredentials) {
        $this->handleDBErrors();
        $this->db->connect();

        $name = $userCredentials->getUsername()->getUsername();
        $pass = $userCredentials->getPassword()->getPassword();

        $isAuthenticated = $this->db->isValid(\login\model\Database::COOKIES_TABLE, $name, $pass);

        if ($isAuthenticated) {
            $this->storage->saveUser($name);
            return true;
        } else {
            throw new WrongNameOrPassword;
        }
    }

    public function updateSavedPwd (\login\model\UserCredentials $credentials) {
        $this->db->connect();
        $this->db->saveCookie($credentials->getUsername()->getUsername(), $credentials->getPassword()->getPassword());
    }

    public function tryToRegister (\login\model\NewUser $newUser) {
        $username = $newUser->getUsername()->getUsername();
        $password = $newUser->getPassword()->getPassword();

        $this->handleDBErrors();
        $this->db->connect();

        if ($this->db->doesUserExist($username)) {
            throw new UserAlreadyExists;
        } else {
            $this->db->registerUser($username, $password);
            $this->storage->saveNameFromRegistration($username);
            return true;
        }
    }

    public function handleDBErrors () {
        if (empty($this->db->DatabaseHasHost())) {
            throw new MissingDBVariable;
          }
    }
}
