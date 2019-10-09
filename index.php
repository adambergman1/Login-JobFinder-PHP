<?php

// require_once('authentication/index.php');
require_once('authentication/controller/MainController.php');
require_once('application/index.php');
require_once('application/view/MainView.php');

error_reporting(E_ALL);
ini_set('display_errors', 'On');
ini_set('display_startup_errors', 'On');

session_start();

// $auth = new \login\Authentication();
$authController = new login\controller\MainController();


$appView = new \application\view\MainView();
$authController->run();
$authController->renderHTML($appView);