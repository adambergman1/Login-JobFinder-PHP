<?php

namespace login\controller;

use login\model\MissingDBVariable;

class MainController {
  private $storage;
  private $authSystem;
  
  private $loginView;
  private $registerView;

  private $loginController;
  private $registerController;

  public function __construct () {
    $this->storage = new \login\model\UserStorage();
    $this->authSystem = new \login\model\AuthenticationSystem($this->storage);

    $this->loginView = new \login\view\LoginView($this->storage);
    $this->registerView = new \login\view\RegisterView();

    $this->loginController = new \login\controller\LoginController($this->loginView, $this->authSystem, $this->storage);
    $this->registerController = new \login\controller\RegisterController($this->registerView, $this->authSystem);
  }

  public function run () {
    try {
      if ($this->loginView->hasCookie() && !$this->isLoggedIn()) {
        $this->loginController->loginByCookie();
      } else if ($this->loginView->userWantsToLogin() && !$this->isLoggedIn()) {
        $this->loginController->login();
      } else if ($this->loginView->userHasClickedLogout() && $this->isLoggedIn()) {
        $this->loginController->logout();
      } else if ($this->loginView->hasCookie() && $this->isLoggedIn()) {
        $this->loginController->generateNewPassword();
      }
      
      if ($this->registerView->userWantsToRegister()) {
        if ($this->registerView->userhasClickedRegister()) {
          $this->registerController->register();
        }
        
        return $this->registerView;
  
      } else if ($this->storage->hasNewRegistreredUser()) {
        $this->loginController->welcomeNewUser();
      }
  
        return $this->loginView;
    } catch (MissingDBVariable $e) {
      $this->loginView->setMessage(\login\view\Messages::EMPTY_DB_STRING);
    }
  }

  public function isLoggedIn () : bool {
    return $this->storage->hasStoredUser();
  }

}