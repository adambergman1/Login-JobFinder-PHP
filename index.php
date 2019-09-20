<?php

namespace login;

session_start();
// var_dump($_SESSION);

error_reporting(E_ALL);
ini_set('display_errors', 'On');
ini_set('display_startup_errors', 'On');

require_once('Application.php');

$app = new \login\Application();
$app->run();

// var_dump($_SESSION);