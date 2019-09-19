<?php

namespace login\model;

require_once('model/Exceptions.php');

class AuthenticationSystem {
    private $isLoggedIn;
    private $loggedInUser;
    private $userCredentials;

    public function __construct () {
        // Ta in databasen
    }

    public function tryToLogin (\login\model\UserCredentials $userCredentials) {
        if ($userCredentials->getUsername()->getUsername() == 'Admin' 
        && $userCredentials->getPassword()->getPassword() == 'Password' ) {
            // Förändra session
            return true;
        } else {
            throw new InvalidCredentialsException("Wrong name or password");
            return false;
        }

        // $db = new \login\model\Database();
        // $db-connect();

    }

    public function isLoggedIn () : bool {
        return $this->isLoggedIn;
    }

    public function getLoggedInUser () {
        throw new Exception("Not implemented yet");
    }

}


// Try to login

// Isloggedin?

// Get logged in user

// Pratar med UserList som har en koppling till databasen?

// Kanske har en session handler som kan titta i sessionen på rätt plats

// Börja med session innan databasen

// Hårdkoda in Admin och Password

