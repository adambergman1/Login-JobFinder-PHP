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
                if ($isLoggedIn) return true;
            } catch (\Exception $e) {
                $this->loginView->setMessage($e->getMessage());
            } 
        }
    }
}

