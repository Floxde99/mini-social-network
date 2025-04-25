<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

//db et Router
require_once('../core/Router.php');
require_once("../src/models/Db.php");
//les repositories
require_once("../src/models/repositories/UserRepository.php");
//modeles
require_once("../src/models/User.php");
//le controller abstract
require_once("../src/controllers/Controller.php");
//les autres controlleurs
require_once('../src/controllers/RegisterController.php');
require_once('../src/controllers/ConfirmController.php');
require_once('../src/controllers/MainController.php'); // Ajout de cette ligne
require_once('../src/controllers/RetourMailController.php');
require_once('../src/controllers/LoginController.php');
require_once('../src/controllers/LogoutController.php');

$router = new Router();
$router->start();