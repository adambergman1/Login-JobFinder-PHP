<?php

namespace login\controller;

class MainController {
  private $storage;
  private $authSystem;
  
  private $loginView;
  private $registerView;

  private $loginController;
  private $registerController;

  private $isLoggedIn;

  public function __construct () {
    $this->storage = new \login\model\UserStorage();
    $this->authSystem = new \login\model\AuthenticationSystem($this->storage);

    $this->loginView = new \login\view\LoginView($this->storage);
    $this->registerView = new \login\view\RegisterView();

    $this->loginController = new \login\controller\LoginController($this->loginView, $this->authSystem);
    $this->registerController = new \login\controller\RegisterController($this->registerView, $this->authSystem);

    $this->isLoggedIn = $this->storage->hasStoredUser();
  }

  public function run () {
    if ($this->loginView->hasCookie() && !$this->isLoggedIn) {
      $this->isLoggedIn = $this->loginController->loginByCookie();
    } else if ($this->loginView->userWantsToLogin() && !$this->isLoggedIn) {
      $this->isLoggedIn = $this->loginController->login();
    } else if ($this->loginView->userHasClickedLogout() && $this->isLoggedIn) {
      $this->isLoggedIn = $this->loginController->logout();
    } else if ($this->loginView->hasCookie() && $this->isLoggedIn) {
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
  }

  public function isLoggedIn () : bool {
    return $this->isLoggedIn;
  }

  // public function renderHTML ($view = null) {
  //   if (!$this->isLoggedIn && $this->layoutView->userWantsToRegister()) {
  //     return $this->registerView;
  //     // return $this->layoutView->render($this->isLoggedIn, $this->registerView, $this->dateTimeView);  
  //   } else if (!$this->isLoggedIn) {
  //     return $this->loginView;
  //     // return $this->layoutView->render($this->isLoggedIn, $this->loginView, $this->dateTimeView);
  //   } 
  //   // else {
  //   //   return $this->layoutView->render($this->isLoggedIn, $this->loginView, $this->dateTimeView, $view);
  //   // }
  // }
}