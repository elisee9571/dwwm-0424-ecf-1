<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
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

        <h1 class="h2 mt-auto">Create an account</h1>
        <div class="nav fs-sm mb-4">
            I already have an account
            <a class="nav-link text-decoration-underline p-0 ms-2" href="/login">Sign in</a>
        </div>

        <!-- Form -->
        <form method="post">
            <div class="d-flex gap-2 mb-3">
                <input type="text" name="name" class="form-control" placeholder="Name" required>

                <input type="text" name="firstname" class="form-control" placeholder="Firstname" required>
            </div>
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="mb-4">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-lg btn-primary w-100">Create an account</button>
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
