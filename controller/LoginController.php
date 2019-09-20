<?php

namespace login\controller;

include_once('view/LoginView.php');

class LoginController {
    private $loginView;
    private $authSystem;
    private $cookie;

    public function __construct(\login\view\LoginView $view, \login\model\AuthenticationSystem $authSystem) {
        $this->loginView = $view;
        $this->authSystem = $authSystem;
        $this->cookie = new \login\model\Cookie();
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
        $cookieName = $this->loginView->getCookieName();
        $cookiePassword = $this->loginView->getCookiePassword();
        $stayLoggedIn = $this->loginView->getKeepLoggedIn();

        $this->cookie->setCookie("username", $cookieName);
        $this->cookie->setCookie("password", $cookiePassword);

        $username = new \login\model\Username($cookieName);
        $password = new \login\model\Password($cookiePassword);

        $credentials = new \login\model\UserCredentials($username, $password, $stayLoggedIn);
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

