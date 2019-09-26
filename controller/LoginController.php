<?php

namespace login\controller;

use Exception;
use login\model\NameAndPasswordMissing;
use login\model\PasswordsDoNotMatch;
use login\model\TooShortNameException;
use login\model\TooShortPasswordException;
use login\model\UserAlreadyExists;

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
        if ($this->registerView->userhasClickedRegister()) {
            try {
                $credentials = $this->registerView->getNewUserCredentials();
                $this->authSystem->tryToRegister($credentials);
                header("Location: ./");
            } catch (TooShortNameException $e) {
                $this->registerView->setMessage($e->getMessage());
            } catch (TooShortPasswordException $e) {
                $this->registerView->setMessage($e->getMessage());
            } catch (NameAndPasswordMissing $e) {
                $this->registerView->setMessage($e->getMessage());
            } catch (PasswordsDoNotMatch $e) {
                $this->registerView->setMessage($e->getMessage());
            } catch (UserAlreadyExists $e) {
                $this->registerView->setMessage($e->getMessage());
            }
        }
    }

    public function welcomeNewUser () {
        $name = $this->storage->getNameFromRegistration();
        $this->loginView->setValueToUsernameField($name);
        $this->loginView->setMessage("Registrered new user.");
        $this->storage->destroySession();
    }

}
