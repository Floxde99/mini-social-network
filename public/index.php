<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Configuration et base de données
require_once('../core/Router.php');
require_once("../src/models/Db.php");

// Models
require_once("../src/models/User.php");
require_once("../src/models/Post.php");

// Repositories
require_once("../src/models/repositories/UserRepository.php");
require_once("../src/models/repositories/PostRepository.php");

// Services
require_once("../src/services/EmailService.php");

// Base Controller
require_once("../src/controllers/Controller.php");

// Auth Controllers
require_once('../src/controllers/LoginController.php');
require_once('../src/controllers/LogoutController.php');
require_once('../src/controllers/RegisterController.php');
require_once('../src/controllers/RetourMailController.php');
require_once('../src/controllers/ConfirmController.php');

// Content Controllers
require_once('../src/controllers/MainController.php');
require_once('../src/controllers/PostsController.php');

// Post Management Controllers
require_once('../src/controllers/CreatePostController.php');
require_once('../src/controllers/EditPostController.php');
require_once('../src/controllers/DeletePostController.php');

// Autres Controllers
require_once('../src/controllers/AboutController.php');
require_once('../src/controllers/PrivacyController.php');
require_once('../src/controllers/ContactController.php');

// Initialisation du router
$router = new Router();
$router->start();