<?php

require_once('authentication/Authentication.php');
require_once('application/JobFinder.php');

error_reporting(E_ALL);
ini_set('display_errors', 'On');
ini_set('display_startup_errors', 'On');

$auth = new \login\Authentication();
$app = new \application\JobFinder($auth);
$app->handleInput();
$app->getOutput();