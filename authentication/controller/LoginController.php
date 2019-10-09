<?php

namespace login\controller;

use Exception;
use login\model\NameAndPasswordMissing;
use login\model\TooShortNameException;
use login\model\TooShortPasswordException;
use login\model\WrongNameOrPassword;

class LoginController {
    private $view;
    private $authSystem;
    private $storage;

    public function __construct(\login\view\LoginView $view, \login\model\AuthenticationSystem $authSystem) {
        $this->view = $view;
        $this->authSystem = $authSystem;
        $this->storage = new \login\model\UserStorage();
    }

    public function login () {
        try {
            $credentials = $this->view->getUserCredentials();
            $isAuthenticated = $this->authSystem->tryToLogin($credentials);

            if ($isAuthenticated) {
                $this->view->setSuccessfulMessage();
                if ($credentials->stayLoggedIn()) {
                    $cookies = $this->view->getCredentialsByCookie();
                    $this->authSystem->updateSavedPwd($cookies);
                }
                return true;
            } else {
                return false;
            }
        
        } catch (NameAndPasswordMissing $e) {
            $this->view->setMessage(\login\view\Messages::NAME_AND_PWD_MISSING);
        } catch (TooShortNameException $e) {
            $this->view->setMessage(\login\view\Messages::TOO_SHORT_NAME);
        } catch (TooShortPasswordException $e) {
            $this->view->setMessage(\login\view\Messages::TOO_SHORT_PWD);
        } catch (WrongNameOrPassword $e) {
            $this->view->setMessage(\login\view\Messages::WRONG_NAME_OR_PWD);
        }
    }

    public function loginByCookie () : bool {
        try {
            $credentials = $this->view->getCredentialsByCookie();

            $this->authSystem->loginWithTemporaryPwd($credentials);
            $this->view->setWelcomeBackMessage();
            return true;
    
        } catch (Exception $e) {
            $this->view->removeCookie();
            $this->storage->destroySession();
            $this->view->setMessage(\login\view\Messages::WRONG_COOKIE_INFO);
            return false;
        }
    }

    public function logout () {
            $this->storage->destroySession();
            $this->view->removeCookie();
            $this->view->setMessage(\login\view\Messages::BYE);
    }

    public function welcomeNewUser () {
        $name = $this->storage->getNameFromRegistration();
        $this->view->setValueToUsernameField($name);
        $this->view->setMessage(\login\view\Messages::NEW_USER_REGISTRERED);
        $this->storage->destroySession();
    }

    public function generateNewPassword () {
        if ($this->view->hasUsername()) {
            $this->view->setCookie();
            $cookies = $this->view->getCredentialsByCookie();
            $this->authSystem->updateSavedPwd($cookies);
        }
    }
}