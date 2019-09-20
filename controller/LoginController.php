<?php

namespace login\controller;

include_once('view/LoginView.php');

class LoginController {
    private $loginView;
    private $authSystem;

    public function __construct(\login\view\LoginView $view, \login\model\AuthenticationSystem $authSystem) {
        $this->loginView = $view;
        $this->authSystem = $authSystem;
    }

    public function login () {
        if ($this->loginView->userWantsToLogin()) {
            try {
                $credentials = $this->loginView->getUserCredentials();
                $isLoggedIn = $this->authSystem->tryToLogin($credentials);
                return $isLoggedIn ? true : false;
            } catch (\Exception $e) {
                $this->loginView->setMessage($e->getMessage());
            } 
        }
    }

    public function loginByCookie () {
        $credentials = $this->authSystem->getCookieCredentials();
        $this->authSystem->tryToLogin($credentials);
    }

    // public function logout () {
    //     if ($this->loginView->userHasClickedLogout()) {
    //         $this->storage->destroySession();
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }
}

