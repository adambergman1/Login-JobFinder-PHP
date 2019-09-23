<?php

namespace login;

//INCLUDE THE FILES NEEDED...
require_once('view/LoginView.php');
require_once('view/RegisterView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');

require_once('LocalSettings.php');
require_once('ProductionSettings.php');

require_once('model/Database.php');
require_once('model/AuthenticationSystem.php');
require_once('model/Username.php');
require_once('model/Password.php');
require_once('model/UserCredentials.php');
require_once('model/UserStorage.php');
require_once('model/Cookie.php');

require_once('controller/LoginController.php');

class Application {
  private $storage;
  private $authSystem;
  private $layoutView;
  private $loginView;
  private $registerView;
  private $dateTimeView;
  private $loginController;
  private $cookie;

  public function __construct () {
    $this->storage = new \login\model\UserStorage();
    $this->cookie = new \login\model\Cookie();
    $this->authSystem = new \login\model\AuthenticationSystem($this->storage);

    $this->layoutView = new \login\view\layoutView();
    $this->dateTimeView = new \login\view\DateTimeView();
    $this->loginView = new \login\view\LoginView($this->storage);
    $this->registerView = new \login\view\RegisterView();

    $this->loginController = new \login\controller\LoginController($this->loginView, $this->authSystem);
  }

  public function run () {
    $isLoggedIn = $this->storage->hasStoredUser();

    if ($this->cookie->hasCookie() && !$isLoggedIn) {
      $isLoggedIn = $this->loginController->loginByCookie();
    } else if ($this->loginView->userWantsToLogin() && !$isLoggedIn) {
      $isLoggedIn = $this->loginController->login();
    } else if ($this->loginView->userHasClickedLogout() && $isLoggedIn) {
      $isLoggedIn = $this->loginController->logout();
    }

    if ($this->layoutView->userHasClickedRegister()) {
      $this->layoutView->render($isLoggedIn, $this->registerView, $this->dateTimeView);
    } else {
      $this->layoutView->render($isLoggedIn, $this->loginView, $this->dateTimeView);
    }

  }
}