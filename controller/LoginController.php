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
    private $cookie;
    private $storage;
    private $registerView;

    public function __construct(\login\view\LoginView $view, 
    \login\model\AuthenticationSystem $authSystem, \login\view\RegisterView $registerView) {
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
                $this->loginView->setMessage( $credentials->stayLoggedIn() 
                ? \login\view\Messages::WELCOME_YOU_WILL_BE_REMEMBERED 
                : \login\view\Messages::WELCOME );
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
            $credentials = $this->cookie->getUserCredentialsByCookie();
            $decodedPwd = $this->cookie->decodePassword($credentials->getPassword()->getPassword());
            $credentials->getPassword()->setPassword($decodedPwd);

            $this->authSystem->tryToLogin($credentials);
            $this->loginView->setMessage(\login\view\Messages::WELCOME_BACK_WITH_COOKIE);
            return true;
    
        } catch (Exception $e) {
            $this->cookie->removeCookie();
            $this->storage->destroySession();
            $this->loginView->setMessage(\login\view\Messages::WRONG_COOKIE_INFO);
            return false;
        }
    }

    public function logout () {
            $this->storage->destroySession();
            $this->cookie->removeCookie();
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
