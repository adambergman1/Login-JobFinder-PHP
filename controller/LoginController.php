<?php

namespace login\controller;

use Exception;
use login\model\TooShortNameException;
use login\model\TooShortPasswordException;

include_once('view/LoginView.php');

class LoginController {
    private $loginView;
    private $authSystem;
    private $cookie;
    private $storage;
    private $registerView;

    public function __construct(\login\view\LoginView $view, \login\model\AuthenticationSystem $authSystem, \login\view\RegisterView $registerView) {
        $this->loginView = $view;
        $this->authSystem = $authSystem;
        $this->storage = new \login\model\UserStorage();
        $this->cookie = new \login\model\Cookie();
        $this->registerView = $registerView;
    }

    public function login () {
        try {
            $credentials = $this->loginView->getUserCredentials();
            $isAuthenticated = $this->authSystem->tryToLogin($credentials);

            if ($isAuthenticated) {
                if ($credentials->stayLoggedIn()) {
                    $this->loginView->setMessage("Welcome and you will be remembered");
                } else {
                    $this->loginView->setMessage("Welcome");
                }
                return true;
            } else {
                return false;
            }
            
        } catch (Exception $e) {
            $this->loginView->setMessage($e->getMessage());
        }
    }

    public function loginByCookie () : bool {
        $credentials = $this->cookie->getUserCredentialsByCookie();
        $isAuthenticated = $this->authSystem->tryToLogin($credentials);

        if ($isAuthenticated) {
            $this->loginView->setMessage("Welcome back with cookie");
            return true;
        } else {
            $this->cookie->removeCookie();
            $this->storage->destroySession();
            $this->loginView->setMessage("Wrong information in cookies");
            return false;
        }
    }

    public function logout () {
            $this->storage->destroySession();
            $this->cookie->removeCookie();
            $this->loginView->setMessage("Bye bye!");
    }

    public function register () {
        $message = "";
        if ($this->registerView->userhasClickedRegister()) {
            try {
                $username = $this->registerView->getUsername();
            } catch (TooShortNameException $e) {
                $message .= $e->getMessage();
                $message .= " ";
            }
            try {
                $password = $this->registerView->getPassword();
            } catch (TooShortPasswordException $e) {
                $message .= $e->getMessage();
            }
            $this->registerView->setMessage($message);
        }
    }
}
