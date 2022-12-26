<?php

require_once '../vendor/autoload.php';
require_once '../framework/autoload.php';
require_once "../controllers/ContentController.php";
require_once "../controllers/Controller404.php";
require_once "../controllers/SearchController.php";
require_once "../controllers/delete_controllers/RowDeleteController.php";
require_once "../controllers/MainController.php";
require_once "../controllers/UserController.php";
require_once "../controllers/MarkController.php";
require_once "../middleware/LoginRequiredMiddleWare.php";
require_once "../controllers/LoginController.php";
require_once "../controllers/LogoutController.php";
require_once "../controllers/CreateStudentController.php";
require_once "../controllers/MarkCreateController.php";

session_start();
if($_SESSION['role'] == 'admin'){
    $loader = new \Twig\Loader\FilesystemLoader('../admin_views');
}else{
    $loader = new \Twig\Loader\FilesystemLoader('../views');
}
$twig = new \Twig\Environment($loader, [
    "debug" => true
]);
$twig->addExtension(new \Twig\Extension\DebugExtension());
$pdo = new PDO("sqlsrv:Server=192.168.56.1,1433;Database=web_sql", "cr4nk", "123", []);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$router = new Router($twig, $pdo);
$router->add("/", MainController::class)
    ->middleware(new LoginRequiredMiddleWare());
$router->add("/login", LoginController::class);
$router->add("/user", UserController::class);
$router->add("/mark", MarkController::class);
$router->add("/search", SearchController::class);
$router->add("/logout", LogoutController::class);
$router->add("/delete", RowDeleteController::class);
$router->add("/add", CreateStudentController::class);
$router->add("/add_marks", MarkCreateController::class);
$router->add("/edit", CreateStudentController::class);

// $router->add("/table", ContentController::class);
$router->get_or_default(Controller404::class);