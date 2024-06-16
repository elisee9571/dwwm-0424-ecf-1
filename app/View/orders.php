<!DOCTYPE html>
<html lang="en">
<head>
    <title>Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
</head>
<body>
<?php require('component/_header.php') ?>

<main class="content-wrapper">
    <!-- Breadcrumb -->
    <nav class="container pt-3 my-3 my-md-4" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Order</li>
        </ol>
    </nav>

    <!-- Page title -->
    <h1 class="h3 container mb-4">List of orders</h1>

    <section class="container pb-5 mb-2">
        <!-- Items list -->
        <?php if (count($data['orders'])): ?>

            <!-- Table of items -->
            <?php foreach ($data['orders'] as $order): ?>
                <table class="table border">
                    <thead>
                    <tr class="table-active">
                        <th scope="col" class="text-dark-emphasis fw-medium py-3">
                            <span class="text-body">CARRIED OUT ON:  <?= date('j F Y', strtotime($order['created_at'])) ?></span>
                        </th>
                        <th scope="col" class="text-dark-emphasis fw-medium py-3">
                            <span class="text-body">TOTAL : <?= $order['total'] ?>€</span>
                        </th>
                        <th scope="col" class="text-dark-emphasis fw-medium py-3">
                            <span class="text-body">N° OF ORDER : <?= $order['order_id'] ?></span>
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    <!-- Items -->
                    <?php foreach ($order['items'] as $product): ?>
                        <tr>
                            <td colspan="3" class="p-3">
                                <div class="d-flex align-items-center">
                                    <img src="https://www.soon7.net/wp-content/uploads/2017/10/placeholder-1.png"
                                         width="110">
                                    <div class="w-100 min-w-0 ps-2 ps-xl-3">
                                        <h5 class="d-flex animate-underline mb-2"><?= $product['product_name'] ?></h5>
                                        <ul class="list-unstyled gap-1 mb-0">
                                            <li>
                                                <span class="text-body-secondary">Quantity:</span>
                                                <span class="text-dark-emphasis fw-medium"><?= $product['quantity'] ?></span>
                                            </li>
                                            <li>
                                                <span class="text-body-secondary">Unit price:</span>
                                                <span class="text-dark-emphasis fw-medium"><?= $product['item_price'] ?>€</span>
                                            </li>
                                            <li>
                                                <span class="text-body-secondary">Total:</span>
                                                <span class="text-dark-emphasis fw-medium"><?= $product['item_price'] * $product['quantity'] ?>€</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    </tbody>
                </table>
            <?php endforeach; ?>

        <?php else: ?>
            <h5>Aucune commande trouvée.</h5>
        <?php endif; ?>
    </section>
</main>
</body>
</html>
