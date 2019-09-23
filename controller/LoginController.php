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
            try {
                $credentials = $this->loginView->getUserCredentials();
                $this->authSystem->tryToLogin($credentials);

                if ($credentials->stayLoggedIn()) {
                    $this->cookie->setCookie($credentials->getUsername()->getUsername(), $credentials->getPassword()->getPassword());
                    $this->loginView->setMessage("Welcome and you will be remembered");
                } else {
                    $this->loginView->setMessage("Welcome");
                }
                return true;
            } catch (\Exception $e) {
                $this->loginView->setMessage($e->getMessage());
                return false;
            }
    }

    public function loginByCookie () : bool {
            // $cookieName = $this->loginView->getCookieName();
            // $cookiePassword = $this->loginView->getCookiePassword();
            // $this->cookie->setCookie($cookieName, $cookiePassword);

            // $stayLoggedIn = $this->loginView->getKeepLoggedIn();
            // $credentials = new \login\model\UserCredentials(new \login\model\Username($cookieName), 
            // new \login\model\Password($cookiePassword), $stayLoggedIn);

            $credentials = $this->cookie->getUserCredentialsByCookie();

            try {
                $this->authSystem->tryToLogin($credentials);
                $this->loginView->setMessage("Welcome back with cookie");
                return true;
            } catch (Exception $e) {
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

