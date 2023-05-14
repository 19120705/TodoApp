<?php
require_once('connection.php');
require_once('models/BaseModel.php');
require_once('controllers/BaseController.php');


$controllerName = ucfirst((strtolower($_REQUEST['controller']) ?? 'Welcome') . 'Controller');
$actionName = $_REQUEST['action'] ?? 'index';

require "./controllers/${controllerName}.php";

$controllerObject = new $controllerName;

$controllerObject->$actionName();

?>