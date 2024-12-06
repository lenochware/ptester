<?php 

require_once "vendor/autoload.php";


session_start();

$app = new PCApp('tester');

$pclib->autoloader->addDirectory('libs');

$app->addConfig('./config.php');
$app->setLayout(isset($_GET['popup'])? 'tpl/popup.tpl' : 'tpl/website.tpl');

PCModel::setOptions(['primaryKey' => 'id']);

$app->layout->_VERSION = 'v1.0.0';
$app->layout->_MENU = file_get_contents('tpl/menu.tpl');

//if (!$app->controller) $app->controller = 'projects';
$app->run();
$app->out();

?>