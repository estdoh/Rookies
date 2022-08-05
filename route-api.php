<?php
require_once 'libs/Router.php';
require_once 'app/ApiProductsController.php';
require_once 'app/ApiCategoryController.php';
require_once 'app/ApiUserController.php';
require_once 'app/ApiCommentsController.php';

// crea el router
$router = new Router();

// define la tabla de ruteo
$router->addRoute('products', 'GET', 'ApiProductController', 'getProducts');
// $router->addRoute('products/:ID', 'GET', 'ApiProductController', 'getProduct');
$router->addRoute('products/:category', 'GET', 'ApiProductController', 'getProductsByCategory');
$router->addRoute('products/:ID', 'DELETE', 'ApiProductController', 'deleteProduct');
$router->addRoute('products', 'POST', 'ApiProductController', 'insertProduct');
$router->addRoute('products/:ID', 'PUT', 'ApiProductController', 'editProduct');
$router->addRoute('categories', 'GET', 'ApiProductController', 'getCategoriesFromProducts');

// $router->addRoute('categories/:ID', 'GET', 'ApiCategoryController', 'getCategory');
// $router->addRoute('categories/:ID', 'DELETE', 'ApiCategoryController', 'deleteCategory');
// $router->addRoute('categories', 'POST', 'ApiCategoryController', 'insertCategory');
// $router->addRoute('categories/:ID', 'PUT', 'ApiCategoryController', 'editCategory');

$router->AddRoute('user/token', 'GET', 'ApiUserController', 'getToken');
$router->AddRoute('user/:ID', 'GET', 'ApiUserController', 'getUser');

// rutea
$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);