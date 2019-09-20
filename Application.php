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
  private $loginController;
  private $cookie;

  public function __construct () {
    $this->storage = new \login\model\UserStorage();
    $this->cookie = new \login\model\Cookie();
    $this->authSystem = new \login\model\AuthenticationSystem($this->storage);
    $this->layoutView = new \login\view\layoutView();
    $this->loginView = new \login\view\LoginView($this->storage);
    $this->loginController = new \login\controller\LoginController($this->loginView, $this->authSystem);
  }

  public function run () {
    $dtv = new \login\view\DateTimeView();

    try {
      if ($this->cookie->hasCookie("name") && !$this->storage->hasStoredUser()) {
        $this->loginController->loginByCookie();
        $this->loginView->setMessage("Welcome back with cookie");
      }
    } catch (\Exception $e) {
      $this->cookie->removeCookie("name");
      $this->cookie->removeCookie("password");
      $this->loginView->setMessage("Wrong information in cookies");
    }
    
    if ($this->storage->hasStoredUser()) {
      $isLoggedIn = true;
      if ($this->loginView->userHasClickedLogout()) {
        $this->storage->destroySession();
        $this->cookie->removeCookie("name");
        $this->cookie->removeCookie("password");
        $this->loginView->setMessage("Bye bye!");
        $isLoggedIn = false;
     } 
    } else {
      $isLoggedIn = $this->loginController->login();

      if ($this->loginView->getKeepLoggedIn() && $isLoggedIn) {
        $this->loginView->setMessage("Welcome and you will be remembered");
      } else if ($isLoggedIn) {
        $this->loginView->setMessage("Welcome");
      }
    }
    $this->layoutView->render($isLoggedIn, $this->loginView, $dtv);
  }

  // private function changeState () {
  //   // $this->loginController->doChangeUsername();
  //   // $this->storage->saveUser($this->user);
  // }
}