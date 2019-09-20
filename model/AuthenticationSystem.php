<?php

namespace login\model;

require_once('model/Exceptions.php');

class AuthenticationSystem {
    private $isLoggedIn;
    private $loggedInUser;
    private $storage;
    private $cookie;

    public function __construct (\login\model\UserStorage $storage) {
        // Ta in databasen
        $this->storage = $storage;
        $this->cookie = new \login\model\Cookie();
    }

    public function tryToLogin (\login\model\UserCredentials $userCredentials) {
        $username = $userCredentials->getUsername()->getUsername();
        $password = $userCredentials->getPassword()->getPassword();

        if ($username == 'Admin' && $password == 'Password' ) {
            // Förändra session
            $this->setLoggedInUser($userCredentials->getUsername());
            $this->cookie->setCookie("username", $username);
            $this->cookie->setCookie("password", $password);

            // $this->setCookie($userCredentials);
            $this->isLoggedIn = true;
            return true;
        } else {
            throw new InvalidCredentialsException("Wrong name or password");
            return false;
        }

        // $db = new \login\model\Database();
        // $db-connect();

    }

    public function getIsUserLoggedIn () : bool {
        return $this->isLoggedIn;
    }

    public function getLoggedInUser () {
        return $this->loggedInUser;
    }

    public function setLoggedInUser ($username) {
        $this->loggedInUser = $this->storage->saveUser($username);
    }

    // private function setCookie (UserCredentials $userCredentials) {
	// 	if ($userCredentials->stayLoggedIn()) {
    //         $username = $userCredentials->getUsername()->getUsername();
    //         $password = $userCredentials->getPassword()->getPassword();
            

	// 		setcookie("username", $username, time() + 1800);
	// 		setcookie("password", $password, time() + 1800);
	// 	}
	// }

	// public function removeCookie () {
	// 	setcookie("username", "", time() - 1800);
	// 	setcookie("password", "", time() - 1800);
    // }
    
    // public function hasCookie () {
    //     return isset($_COOKIE["username"]) && isset($_COOKIE["password"]);
    // }

    // public function getCookieCredentials () {
    //     $username = new \login\model\Username($_COOKIE["username"]);
    //     $pass = new \login\model\Password($_COOKIE["password"]);

    //     return new \login\model\UserCredentials($username, $pass, true);
    // }

}


// Try to login

// Isloggedin?

// Get logged in user

// Pratar med UserList som har en koppling till databasen?

// Kanske har en session handler som kan titta i sessionen på rätt plats

// Börja med session innan databasen

// Hårdkoda in Admin och Password

