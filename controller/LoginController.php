<?php

namespace login\controller;

use Exception;
use login\model\NameAndPasswordMissing;
use login\model\PasswordsDoNotMatch;
use login\model\TooShortNameException;
use login\model\TooShortPasswordException;
use login\model\UserAlreadyExists;
use login\model\InvalidCharactersException;
use login\model\WrongNameOrPassword;

include_once('view/LoginView.php');

class LoginController {
    private $loginView;
    private $authSystem;
    private $storage;
    private $registerView;

    public function __construct(\login\view\LoginView $view, 
    \login\model\AuthenticationSystem $authSystem, \login\view\RegisterView $registerView) {
        $this->loginView = $view;
        $this->authSystem = $authSystem;
        $this->storage = new \login\model\UserStorage();
        $this->registerView = $registerView;
    }

    public function login () {
        try {
            $credentials = $this->loginView->getUserCredentials();
            $isAuthenticated = $this->authSystem->tryToLogin($credentials);

            if ($isAuthenticated) {
                $this->loginView->setSuccessfulMessage();
                return true;
            } else {
                return false;
            }   
        
        } catch (NameAndPasswordMissing $e) {
            $this->loginView->setMessage(\login\view\Messages::NAME_AND_PWD_MISSING);
        } catch (TooShortNameException $e) {
            $this->loginView->setMessage(\login\view\Messages::TOO_SHORT_NAME);
        } catch (TooShortPasswordException $e) {
            $this->loginView->setMessage(\login\view\Messages::TOO_SHORT_PWD);
        } catch (WrongNameOrPassword $e) {
            $this->loginView->setMessage(\login\view\Messages::WRONG_NAME_OR_PWD);
        }
    }

    public function loginByCookie () : bool {
        try {
            $credentials = $this->loginView->getCredentialsByCookie();
            $this->authSystem->tryToLogin($credentials);
            $this->loginView->setWelcomeBackMessage();
            return true;
    
        } catch (Exception $e) {
            $this->loginView->removeCookie();
            $this->storage->destroySession();
            $this->loginView->setMessage(\login\view\Messages::WRONG_COOKIE_INFO);
            return false;
        }
    }

    public function logout () {
            $this->storage->destroySession();
            $this->loginView->removeCookie();
            $this->loginView->setMessage(\login\view\Messages::BYE);
    }

    public function register () {
        if ($this->registerView->userhasClickedRegister()) {
            try {
                $credentials = $this->registerView->getNewUserCredentials();
                $this->authSystem->tryToRegister($credentials);
                header("Location: ./");
            } catch (TooShortNameException $e) {
                $this->registerView->setMessage(\login\view\Messages::TOO_SHORT_NAME);
            } catch (TooShortPasswordException $e) {
                $this->registerView->setMessage(\login\view\Messages::TOO_SHORT_PWD);
            } catch (NameAndPasswordMissing $e) {
                $this->registerView->setMessage(\login\view\Messages::NAME_AND_PWD_MISSING);
            } catch (PasswordsDoNotMatch $e) {
                $this->registerView->setMessage(\login\view\Messages::PASSWORDS_DONT_MATCH);
            } catch (UserAlreadyExists $e) {
                $this->registerView->setMessage(\login\view\Messages::USER_ALREADY_EXISTS);
            } catch (InvalidCharactersException $e) {
                $this->registerView->setMessage(\login\view\Messages::INVALID_CHARACTERS);
            }
        }
    }

    public function welcomeNewUser () {
        $name = $this->storage->getNameFromRegistration();
        $this->loginView->setValueToUsernameField($name);
        $this->loginView->setMessage(\login\view\Messages::NEW_USER_REGISTRERED);
        $this->storage->destroySession();
    }

}
