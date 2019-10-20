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

    public function __construct(\login\view\LoginView $view, \login\model\AuthenticationSystem $authSystem, 
    \login\model\UserStorage $storage) {
        $this->view = $view;
        $this->authSystem = $authSystem;
        $this->storage = $storage;
    }

    public function login () : void {
        try {
            $credentials = $this->view->getUserCredentials();
            $this->authSystem->tryToLogin($credentials);
            $this->view->setSuccessfulMessage();
            
            if ($credentials->stayLoggedIn()) {
                $cookies = $this->view->getCredentialsByCookie();
                $this->authSystem->updateSavedPwd($cookies);
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

    public function loginByCookie () : void {
        try {
            $credentials = $this->view->getCredentialsByCookie();
            $this->authSystem->loginWithTemporaryPwd($credentials);
            $this->view->setWelcomeBackMessage();
    
        } catch (Exception $e) {
            $this->view->removeCookie();
            $this->storage->destroySession();
            $this->view->setMessage(\login\view\Messages::WRONG_COOKIE_INFO);
        }
    }

    public function logout () : void {
        $this->storage->destroySession();
        $this->view->removeCookie();
        $this->view->setMessage(\login\view\Messages::BYE);
    }

    public function welcomeNewUser () : void {
        $name = $this->storage->getNameFromRegistration();
        $this->view->setValueToUsernameField($name);
        $this->view->setMessage(\login\view\Messages::NEW_USER_REGISTRERED);
        $this->storage->destroySession();
    }

    public function generateNewPassword () : void {
        if ($this->view->hasUsername()) {
            $this->view->setCookie();
            $cookies = $this->view->getCredentialsByCookie();
            $this->authSystem->updateSavedPwd($cookies);
        }
    }
}