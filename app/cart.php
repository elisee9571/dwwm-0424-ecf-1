<?php
session_start();

use Model\Database;

include_once 'Model/Database.php';

$database = new Database();
$db = $database->connect();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

$products = [];
$total = 0;
$countItems = 0;

if (!empty($cart)) {
    $product_ids = array_keys($cart);
    $placeholders = implode(',', array_fill(0, count($product_ids), '?'));
    $stmt = $db->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
    $stmt->execute($product_ids);
    $fetchedProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Associer les quantités et calculer les totaux pour chaque produit
    foreach ($fetchedProducts as $key => $product) {
        $quantity = $cart[$product['id']];
        $total_price = $product['price'] * $quantity;

        // Mettre à jour le tableau original $products avec les données calculées
        $fetchedProducts[$key]['quantity'] = $quantity;
        $fetchedProducts[$key]['total_price'] = $total_price;

        // Calculer le total général et le nombre total d'articles
        $total += $total_price;
        $countItems += $quantity;
    }

    // Affecter $fetchedProducts à $products pour l'utiliser plus loin dans votre code
    $products = $fetchedProducts;
}
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
    <script defer>
        $(document).ready(function () {
            $('[data-action="increment"]').on('click', function () {
                var productId = $(this).data('product-id');
                var inputQuantity = $(this).siblings('input[type="number"]');
                var currentQuantity = parseInt(inputQuantity.val());
                inputQuantity.val(currentQuantity + 1);

                // Envoyer la mise à jour de la quantité au serveur via AJAX si nécessaire
                updateCart(productId, currentQuantity + 1);
            });

            $('[data-action="decrement"]').on('click', function () {
                var productId = $(this).data('product-id');
                var inputQuantity = $(this).siblings('input[type="number"]');
                var currentQuantity = parseInt(inputQuantity.val());
                if (currentQuantity > 1) {
                    inputQuantity.val(currentQuantity - 1);

                    // Envoyer la mise à jour de la quantité au serveur via AJAX si nécessaire
                    updateCart(productId, currentQuantity - 1);
                }
            });

            function updateCart(productId, newQuantity) {
                // Exemple d'AJAX pour envoyer la mise à jour de la quantité au serveur
                $.post('update_to_cart.php', {'productId': productId, 'quantity': newQuantity})
                    .done(response => window.location.reload())
                    .fail(error => console.error('Erreur lors de la mise à jour du panier:', error))
            }

            $('.remove-item-btn').on('click', function () {
                var productId = $(this).data('product-id');

                // Envoyer la demande de suppression au serveur via AJAX
                $.post('remove_item_to_cart.php', {'productId': productId})
                    .done(response => window.location.reload())
                    .fail(error => console.error('Erreur lors de la mise à jour du panier:', error))
            });
        });
    </script>
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
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-bag" viewBox="0 0 16 16">
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
            <li class="breadcrumb-item" aria-current="page">Catalog</li>
            <li class="breadcrumb-item active" aria-current="page">Cart</li>
        </ol>
    </nav>

    <!-- Page title -->
    <h1 class="h3 container mb-4">Shopping cart</h1>

    <section class="container pb-5 mb-2 mb-md-3 mb-lg-4 mb-xl-5">
        <div class="row">

            <!-- Items list -->
            <div class="col-lg-8">
                <div class="pe-lg-2 pe-xl-3 me-xl-3">

                    <!-- Table of items -->
                    <table class="table position-relative z-2 mb-4">
                        <thead>
                        <tr>
                            <th scope="col" class="fs-sm fw-normal py-3 ps-0">
                                <span class="text-body">Product</span>
                            </th>
                            <th scope="col" class="text-body fs-sm fw-normal py-3 d-none d-xl-table-cell">
                                <span class="text-body">Price</span>
                            </th>
                            <th scope="col" class="text-body fs-sm fw-normal py-3 d-none d-md-table-cell">
                                <span class="text-body">Quantity</span>
                            </th>
                            <th scope="col" class="text-body fs-sm fw-normal py-3 d-none d-md-table-cell">
                                <span class="text-body">Total</span>
                            </th>
                            <th scope="col" class="text-body fs-sm fw-normal py-3 d-none d-md-table-cell">
                                <span class="text-body">Action</span>
                            </th>
                        </tr>
                        </thead>

                        <tbody class="align-middle">
                        <!-- Items -->
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td class="py-3 ps-0">
                                    <div class="d-flex align-items-center">
                                        <a class="flex-shrink-0" href="shop-product-general-electronics.html">
                                            <img src="https://www.soon7.net/wp-content/uploads/2017/10/placeholder-1.png"
                                                 width="110">
                                        </a>
                                        <div class="w-100 min-w-0 ps-2 ps-xl-3">
                                            <h5 class="d-flex animate-underline mb-2"><?= $product['name'] ?></h5>
                                            <ul class="list-unstyled gap-1 fs-xs mb-0">
                                                <li class="d-xl-none">
                                                    <span class="text-body-secondary">Price:</span>
                                                    <span class="text-dark-emphasis fw-medium"><?= $product['price'] ?>€</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                                <td class="h6 py-3 d-none d-xl-table-cell"><?= $product['price'] ?></td>
                                <td class="py-3 d-none d-md-table-cell">
                                    <div class="d-flex">
                                        <button type="button" class="btn btn-icon" data-action="decrement"
                                                data-product-id="<?= $product['id'] ?>" aria-label="Decrement quantity">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                 fill="currentColor" class="bi bi-dash" viewBox="0 0 16 16">
                                                <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8"/>
                                            </svg>
                                        </button>
                                        <input type="number" class="form-control"
                                               value="<?= number_format($product['quantity'], 0) ?>" readonly>
                                        <button type="button" class="btn btn-icon" data-action="increment"
                                                data-product-id="<?= $product['id'] ?>" aria-label="Increment quantity">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                 fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                                <td class="h6 py-3 d-none d-md-table-cell">
                                    <?= number_format($product['total_price'], 2) ?>€
                                </td>
                                <td class="text-end py-3 px-0">
                                    <button type="button" class="btn-close fs-sm remove-item-btn"
                                            data-product-id="<?= $product['id'] ?>"></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>

                    <div class="nav position-relative z-2 mb-4 mb-lg-0">
                        <a class="nav-link animate-underline px-0" href="/">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-chevron-left" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                      d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0"/>
                            </svg>
                            <span class="animate-target">Continue shopping</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Order summary (sticky sidebar) -->
            <aside class="col-lg-4" style="margin-top: -100px">
                <div class="position-sticky top-0" style="padding-top: 100px">
                    <div class="bg-body-tertiary rounded-5 p-4 mb-3">
                        <div class="p-sm-2 p-lg-0 p-xl-2">
                            <h5 class="border-bottom pb-4 mb-4">Order summary</h5>
                            <ul class="list-unstyled fs-sm gap-3 mb-0">
                                <li class="d-flex justify-content-between">
                                    Subtotal (<?= $countItems ?> items):
                                    <span class="text-dark-emphasis fw-medium"><?= $total ?>€</span>
                                </li>
                            </ul>
                            <div class="border-top pt-4 mt-4">
                                <div class="d-flex justify-content-between mb-3">
                                    <span class="fs-sm">Estimated total:</span>
                                    <span class="h5 mb-0"><?= $total ?>€</span>
                                </div>
                                <a class="btn btn-lg btn-primary w-100" href="order.php">
                                    Proceed to checkout
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </section>

</main>

</body>
</html>
