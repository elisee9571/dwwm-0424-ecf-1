<?php
session_start();

use Model\Database;
use Repository\ProductRepository;

include_once 'Model/Database.php';
include_once 'Model/Product.php';
include_once 'Repository/ProductRepository.php';

$database = new Database();
$db = $database->connect();

$productRepository = new ProductRepository($db);
$products = $productRepository->findAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Liste des produits</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
</head>
<body>
<nav class="navbar bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">E-commerce</a>
        <ul class="nav">
            <?php if (isset($_SESSION['user_id'])): ?>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="cart.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bag" viewBox="0 0 16 16">
                            <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z"/>
                        </svg>
                    </a>
                </li>

                <div class="dropdown dropdown-profile">
                    <button class="btn btn-outline-light dropdown-toggle rounded-1 text-muted" type="button"
                            id="dropdown-menu-profile" data-bs-toggle="dropdown" aria-expanded="false">
                        <?= $_SESSION['user_email'] ?>
                    </button>
                    <ul class="dropdown-menu rounded-1" aria-labelledby="dropdown-menu-profile">
                        <li>
                            <a class="dropdown-item" href="logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
            <?php else: ?>
                <div class="d-flex gap-2">
                    <li class="nav-item">
                        <a href="login.php" class="btn btn-primary">Sign in</a>
                    </li>
                    <li class="nav-item">
                        <a href="register.php" class="btn btn-outline-secondary">Register</a>
                    </li>
                </div>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<main class="content-wrapper">

    <!-- Breadcrumb -->
    <nav class="container pt-3 my-3 my-md-4" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Catalog</li>
        </ol>
    </nav>

    <!-- Page title -->
    <h1 class="h3 container mb-4">Shop catalog</h1>

    <!-- Selected filters + Sorting -->
    <section class="container mb-4">
        <div class="row">
            <div class="col-lg-9">
                <div class="h6 fs-sm fw-normal text-nowrap translate-middle-y mt-3 mb-0 me-4">
                    Found <span class="fw-semibold"><?= count($products) ?></span> items
                </div>
            </div>
            <div class="col-lg-3 mt-3 mt-lg-0">
                <select class="form-select">
                    <option value="1">Relevance</option>
                    <option value="1">Popularity</option>
                    <option value="1">Price: Low to High</option>
                    <option value="1">Price: High to Low</option>
                    <option value="1">Newest Arrivals</option>
                </select>
            </div>
        </div>
        <hr class="d-lg-none my-3">
    </section>

    <!-- Products grid + Sidebar with filters -->
    <section class="container pb-5 mb-sm-2 mb-md-3 mb-lg-4 mb-xl-5">
        <div class="row">

            <!-- Filter sidebar that turns into offcanvas on screens < 992px wide (lg breakpoint) -->
            <aside class="col-lg-3">
                <div class="offcanvas-lg offcanvas-start" id="filterSidebar">
                    <div class="offcanvas-header py-3">
                        <h5 class="offcanvas-title">Filter and sort</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                data-bs-target="#filterSidebar" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body flex-column pt-2 py-lg-0">

                        <!-- Status -->
                        <div class="w-100 border rounded p-3 p-xl-4 mb-3 mb-xl-4">
                            <h4 class="h6">Status</h4>
                            <div class="d-flex flex-wrap gap-2">
                                <button type="button" class="btn btn-sm btn-outline-secondary">
                                    <i class="ci-percent fs-sm me-1 ms-n1"></i>
                                    Sale
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-secondary">Same Day Delivery
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-secondary">Available to Order
                                </button>
                            </div>
                        </div>

                        <!-- Categories -->
                        <div class="w-100 border rounded p-3 p-xl-4 mb-3 mb-xl-4">
                            <h4 class="h6 mb-2">Categories</h4>
                            <ul class="list-unstyled d-block m-0">
                                <li class="nav d-block pt-2 mt-1">
                                    <a class="nav-link animate-underline fw-normal p-0" href="#!">
                                        <span class="animate-target text-truncate me-3">Smartphones</span>
                                        <span class="text-body-secondary fs-xs ms-auto">218</span>
                                    </a>
                                </li>
                                <li class="nav d-block pt-2 mt-1">
                                    <a class="nav-link animate-underline fw-normal p-0" href="#!">
                                        <span class="animate-target text-truncate me-3">Accessories</span>
                                        <span class="text-body-secondary fs-xs ms-auto">372</span>
                                    </a>
                                </li>
                                <li class="nav d-block pt-2 mt-1">
                                    <a class="nav-link animate-underline fw-normal p-0" href="#!">
                                        <span class="animate-target text-truncate me-3">Tablets</span>
                                        <span class="text-body-secondary fs-xs ms-auto">110</span>
                                    </a>
                                </li>
                                <li class="nav d-block pt-2 mt-1">
                                    <a class="nav-link animate-underline fw-normal p-0" href="#!">
                                        <span class="animate-target text-truncate me-3">Wearable Electronics</span>
                                        <span class="text-body-secondary fs-xs ms-auto">142</span>
                                    </a>
                                </li>
                                <li class="nav d-block pt-2 mt-1">
                                    <a class="nav-link animate-underline fw-normal p-0" href="#!">
                                        <span class="animate-target text-truncate me-3">Computers &amp; Laptops</span>
                                        <span class="text-body-secondary fs-xs ms-auto">205</span>
                                    </a>
                                </li>
                                <li class="nav d-block pt-2 mt-1">
                                    <a class="nav-link animate-underline fw-normal p-0" href="#!">
                                        <span class="animate-target text-truncate me-3">Cameras, Photo &amp; Video</span>
                                        <span class="text-body-secondary fs-xs ms-auto">78</span>
                                    </a>
                                </li>
                                <li class="nav d-block pt-2 mt-1">
                                    <a class="nav-link animate-underline fw-normal p-0" href="#!">
                                        <span class="animate-target text-truncate me-3">Headphones</span>
                                        <span class="text-body-secondary fs-xs ms-auto">121</span>
                                    </a>
                                </li>
                                <li class="nav d-block pt-2 mt-1">
                                    <a class="nav-link animate-underline fw-normal p-0" href="#!">
                                        <span class="animate-target text-truncate me-3">Video Games</span>
                                        <span class="text-body-secondary fs-xs ms-auto">89</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Product grid -->
            <div class="col-lg-9">
                <div class="row row-cols-2 row-cols-md-3 g-4 pb-3 mb-3">

                    <?php foreach ($products as $product): ?>
                        <!-- Items -->
                        <div class="col">
                            <div class="card rounded">
                                <img class="card-img-top"
                                     src="https://www.soon7.net/wp-content/uploads/2017/10/placeholder-1.png">
                                <div class=" px-1 pb-2 px-sm-3 pb-sm-3">
                                    <h4 class="py-4"><?= $product->getName() ?></h4>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="h5 lh-1 mb-0"><?= $product->getPrice() . ' €' ?></div>
                                        <form method="post" action="add_to_cart.php">
                                            <input type="hidden" name="product_id" value="<?= $product->getId() ?>">
                                            <button class="btn btn-danger" type="submit">Ajouter au panier</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    </section>
</main>

</body>
</html>
