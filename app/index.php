<?php

session_start();

use Router\Router;

include_once __DIR__ . '/vendor/Router/Router.php';


$routes = [
    '/' => 'Controller\AppController::home',
    '/login' => 'Controller\UserController::login',
    '/register' => 'Controller\UserController::register',
    '/logout' => 'Controller\UserController::logout',
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
