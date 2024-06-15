<?php

namespace Controller;

use Model\User;
use Service\UserService;

include_once __DIR__ . '/../vendor/Framework/AbstractController.php';
include_once __DIR__ . '/../Model/User.php';
include_once __DIR__ . '/../Service/UserService.php';

class UserController extends \AbstractController
{
    private UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function register(): string
    {
        $user = new User();
        $request = [];

        foreach ($_REQUEST as $property => $value) {
            $request[htmlspecialchars(strip_tags(trim($property)))] = htmlspecialchars(strip_tags(trim($value)));
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user->setEmail($request['email']);
            $user->setLastname($request['lastname']);
            $user->setFirstname($request['firstname']);
            $user->setPassword($request['password']);

            if ($this->userService->register($user)) {
                header('Location: /login');
                exit;
            } else {
                echo 'Erreur lors de l\'inscription.';
            }
        }

        return $this->render('register');
    }

    public function login(): string
    {
        $user = new User();
        $request = [];

        foreach ($_REQUEST as $property => $value) {
            $request[htmlspecialchars(strip_tags(trim($property)))] = htmlspecialchars(strip_tags(trim($value)));
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user->setEmail($request['email']);
            $user->setPassword($request['password']);

            if ($this->userService->login($user)) {
                header('Location: /');
                exit;
            } else {
                echo 'Erreur lors de l\'authentification.';
            }
        }

        return $this->render('login');
    }

    public function logout(): void
    {
        unset($_SESSION['user']);
        header('Location: /login');
        exit;
    }
}