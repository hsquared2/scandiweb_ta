<?php


include_once('init.php');
include_once('vendor/autoload.php');

const BASE_URL = '/scandiweb_ta/';
const DB_HOST = 'localhost';
const DB_NAME = 'scandiweb_test';
const DB_USER = 'root';
const DB_PASS = '';

use Products\Controllers\Index as ProductsController;
use System\Router;

$router = new Router(BASE_URL);
$router->addRoute('', ProductsController::class);
$router->addRoute('add-product', ProductsController::class, 'add');


$uri = $_SERVER['REQUEST_URI'];
$activeRoute = $router->resolvePath($uri);

$controller = $activeRoute['controller'];
$method = $activeRoute['method'];

$controller->$method();
$html = $controller->render();
echo $html;

