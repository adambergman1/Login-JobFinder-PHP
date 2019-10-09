<?php

namespace login;

session_start();

error_reporting(E_ALL);
ini_set('display_errors', 'On');
ini_set('display_startup_errors', 'On');

require_once('controller/MainController.php');

$app = new \login\controller\MainController();
$app->run();
