<?php

require_once('authentication/Authentication.php');
require_once('application/index.php');
require_once('application/view/MainView.php');

error_reporting(E_ALL);
ini_set('display_errors', 'On');
ini_set('display_startup_errors', 'On');

$auth = new \login\Authentiction();
$authController = new \login\controller\MainController();

$appView = new \application\view\MainView();
$authController->renderHTML($appView);