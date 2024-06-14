<?php
session_start();

// Vérifiez si les données POST sont bien présentes
if (isset($_POST['productId']) && isset($_POST['quantity'])) {
    $product_id = $_POST['productId'];
    $quantity = $_POST['quantity'];

    // Assurez-vous que la quantité est un entier positif
    $quantity = max(0, intval($quantity));

    // Vérifiez si le produit existe dans le panier
    if (isset($_SESSION['cart'][$product_id])) {
        // Mettez à jour la quantité du produit dans le panier
        $_SESSION['cart'][$product_id] = $quantity;

        echo 'Panier mis à jour avec succès.';
    } else {
        echo 'Produit non trouvé dans le panier.';
    }
} else {
    echo 'Données manquantes pour la mise à jour du panier.';
}
