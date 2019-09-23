<?php

namespace login\controller;

include_once('view/LoginView.php');

class LoginController {
    private $loginView;
    private $authSystem;
    private $cookie;
    private $storage;

    public function __construct(\login\view\LoginView $view, \login\model\AuthenticationSystem $authSystem) {
        $this->loginView = $view;
        $this->authSystem = $authSystem;
        $this->cookie = new \login\model\Cookie();
        $this->storage = new \login\model\UserStorage();
    }

    public function login () : bool {
        $credentials = $this->loginView->getUserCredentials();
        $isAuthenticated = $this->authSystem->tryToLogin($credentials);

        if ($isAuthenticated) {
            if ($credentials->stayLoggedIn()) {
                $this->cookie->setCookie($credentials->getUsername()->getUsername(), $credentials->getPassword()->getPassword());
                $this->loginView->setMessage("Welcome and you will be remembered");
            } else {
                $this->loginView->setMessage("Welcome");
            }
            return true;
        } else {
            $this->loginView->setMessage("Wrong name or password");
            return false;
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
}
