<?php

namespace login\controller;

use login\model\TooShortNameException;
use login\model\TooShortPasswordException;
use login\model\NameAndPasswordMissing;
use login\model\PasswordsDoNotMatch;
use login\model\UserAlreadyExists;
use login\model\InvalidCharactersException;

class RegisterController {
    private $view;
    private $authSystem;

    public function __construct (\login\view\RegisterView $view, \login\model\AuthenticationSystem $authSystem) {
        $this->view = $view;
        $this->authSystem = $authSystem;
    }

    public function register () : void {
        if ($this->view->userhasClickedRegister()) {
            try {
                $credentials = $this->view->getNewUserCredentials();
                $this->authSystem->tryToRegister($credentials);
                header("Location: ./");
            } catch (TooShortNameException $e) {
                $this->view->setMessage(\login\view\Messages::TOO_SHORT_NAME);
            } catch (TooShortPasswordException $e) {
                $this->view->setMessage(\login\view\Messages::TOO_SHORT_PWD);
            } catch (NameAndPasswordMissing $e) {
                $this->view->setMessage(\login\view\Messages::NAME_AND_PWD_MISSING);
            } catch (PasswordsDoNotMatch $e) {
                $this->view->setMessage(\login\view\Messages::PASSWORDS_DONT_MATCH);
            } catch (UserAlreadyExists $e) {
                $this->view->setMessage(\login\view\Messages::USER_ALREADY_EXISTS);
            } catch (InvalidCharactersException $e) {
                $this->view->setMessage(\login\view\Messages::INVALID_CHARACTERS);
            }
        }
    }
}