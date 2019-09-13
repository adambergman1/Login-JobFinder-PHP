<?php

namespace login;

//INCLUDE THE FILES NEEDED...
require_once('DatabaseConfig.php');
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('model/Database.php');
require_once('model/LoginModel.php');
require_once('controller/LoginController.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

//CREATE OBJECTS OF THE VIEWS
$v = new \login\view\LoginView();
$dtv = new \login\view\DateTimeView();
$lv = new \login\view\LayoutView();
$db = new \login\model\Database();
$loginView = new \login\model\LoginModel(); 
$loginController = new \login\controller\LoginController($v);

$db->connect();


$lv->render(false, $v, $dtv);

$serverName = gethostbyaddr($_SERVER['REMOTE_ADDR']);
echo $serverName;

if ($serverName == 'localhost') {
    echo "You are on localhost";
}
?>