<?php
session_start();

include_once 'vendor/Router/Router.php';

$routes = [
    '/' => 'Controller\AppController::home',
    '/login' => 'Controller\UserController::login',
    '/register' => 'Controller\UserController::register',
    '/logout' => 'Controller\UserController::logout',
    '/cart' => 'Controller\CartController::cart',
    '/add-item-to-cart' => 'Controller\CartController::addItemToCart',
    '/remove-item-to-cart' => 'Controller\CartController::removeItemToCart',
    '/update-item-to-cart' => 'Controller\CartController::updateItemToCart',
    '/order' => 'Controller\OrderController::order',
    '/orders' => 'Controller\OrderController::orders',
    '/order/success' => 'Controller\OrderController::success',
];

$router = new Router;

$action = $router->getAction($routes[$_SERVER['REQUEST_URI']]);

$controller = $action[0];
$method = $action[1];

include_once __DIR__ . '/' . str_replace('\\', '/', $controller) . '.php';

$controller = new $controller;
$response = $controller->$method();

echo $response;
