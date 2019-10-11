<?php

namespace login;

use Exception;

# View
require_once('view/LoginView.php');
require_once('view/RegisterView.php');
require_once('view/Messages.php');
require_once('view/ErrorView.php');

# Settings
require_once('LocalSettings.php');
require_once('ProductionSettings.php');

# Model
require_once('model/Database.php');
require_once('model/AuthenticationSystem.php');
require_once('model/Username.php');
require_once('model/Password.php');
require_once('model/UserCredentials.php');
require_once('model/NewUser.php');
require_once('model/UserStorage.php');
require_once('model/Exceptions.php');

# Controller
require_once('controller/LoginController.php');
require_once('controller/RegisterController.php');
require_once('controller/MainController.php');

session_start();

class Authentication {
    private $mainController;

    public function __construct () {
        $this->mainController = new \login\controller\MainController();
    }

    public function getMainController () {
        try {
            return $this->mainController;
        } catch (Exception $e) {
            ErrorView::echoError($e->getMessage());
        }
    }
}