<?php
session_start();

use Model\Database;
use Model\User;

include_once 'Model/Database.php';
include_once 'Model/User.php';

$database = new Database();
$db = $database->connect();

$user = new User($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user->setEmail($_POST['email']);
    $user->setPassword($_POST['password']);

    if ($user->login()) {
        $_SESSION['user_id'] = $user->getId();
        $_SESSION['user_email'] = $user->getEmail();
        header('Location: index.php');
        exit;
    } else {
        echo 'Erreur lors de l\'authentification.';
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
</head>
<body>
<main class="content-wrapper w-100 px-3 ps-lg-5 pe-lg-4 mx-auto" style="max-width: 1920px">

    <!-- Login form + Footer -->
    <div class="d-flex flex-column min-vh-100 w-100 py-4 m-auto" style="max-width: 416px">

        <!-- Logo -->
        <header class="navbar px-0 pb-4 mt-n2 mt-sm-0 mb-2 mb-md-3 mb-lg-4">
            <a href="/" class="navbar-brand d-flex">E-commerce</a>
        </header>

        <h1 class="h2 mt-auto">Welcome back</h1>
        <div class="nav fs-sm mb-4">
            Don't have an account?
            <a class="nav-link text-decoration-underline p-0 ms-2" href="register.php">Create an account</a>
        </div>

        <!-- Form -->
        <form method="post" action="login.php">
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="mb-4">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <div class="text-end mb-4">
                <a class="nav-link text-decoration-underline p-0" href="#">Forgot password?</a>
            </div>
            <button type="submit" class="btn btn-lg btn-primary w-100">Sign In</button>
        </form>

        <!-- Footer -->
        <footer class="mt-auto">
            <div class="nav mb-4">
                <a class="nav-link text-decoration-underline p-0" href="#">Need help?</a>
            </div>
            <p class="fs-xs mb-0">
                © All rights reserved. Made by M2I Formation
            </p>
        </footer>
    </div>
</main>
</body>
</html>