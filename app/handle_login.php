<?php
include_once __DIR__ . '/Controller/UserController.php';

$userController = new \Controller\UserController();
$request = [];
foreach ($_REQUEST as $property => $value) {
    $request[htmlspecialchars(strip_tags(trim($property)))] = htmlspecialchars(strip_tags(trim($value)));
}
$userController->login($request);
