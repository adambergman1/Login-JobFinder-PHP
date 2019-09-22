<?php

namespace login;

//INCLUDE THE FILES NEEDED...
require_once('view/LoginView.php');
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
    $this->loginController = new \login\controller\LoginController($this->loginView, $this->authSystem);
  }

  public function run () {

    $isLoggedIn = $this->storage->hasStoredUser();

    if ($this->cookie->hasCookie() && !$isLoggedIn) {
      echo "LOGIN BY COOKIE";
      $isLoggedIn = $this->loginController->loginByCookie();
    } else if ($this->loginView->userWantsToLogin() && !$isLoggedIn) {
      echo "LOGIN WITHOUT BEING LOGGED IN";
      $isLoggedIn = $this->loginController->login();
    } else if ($this->loginView->userHasClickedLogout() && $isLoggedIn) {
      echo "LOGOUT WHILE BEING LOGGED IN";
      $isLoggedIn = $this->loginController->logout();
    }

      $this->layoutView->render($isLoggedIn, $this->loginView, $this->dateTimeView);
  }

  // private function changeState () {
  //   // $this->loginController->doChangeUsername();
  //   // $this->storage->saveUser($this->user);
  // }
}