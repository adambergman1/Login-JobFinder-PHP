<?php

namespace login;

# View
require_once('view/LoginView.php');
require_once('view/RegisterView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('view/Messages.php');

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

# Controller
require_once('controller/LoginController.php');
require_once('controller/RegisterController.php');
require_once('controller/MainController.php');

session_start();

class Authentiction {
    public function __construct () {
        $app = new \login\controller\MainController();
        $app->run();
    }
}