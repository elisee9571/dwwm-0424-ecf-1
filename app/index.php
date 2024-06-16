<?php

use Router\Router;

include_once __DIR__ . '/vendor/Router/Router.php';

session_start();

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

/* @info : contrôle les données venant du front (($_GET, $_POST, $_COOKIE) mais pas le $_FILE) et nous premunis des failles XSS */
$request = [];
foreach ($_REQUEST as $property => $value) {
    $request[htmlspecialchars(strip_tags(trim($property)))] = htmlspecialchars(strip_tags(trim($value)));
}

$controller = new $controller;
$response = $controller->$method($request);

echo $response;
