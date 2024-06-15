<?php
session_start();

if (isset($_POST['productId'])) {
    $product_id = $_POST['productId'];

    // Vérifiez si le produit existe dans le panier
    if (isset($_SESSION['cart'][$product_id])) {
        // Supprimez le produit du panier
        unset($_SESSION['cart'][$product_id]);

        echo 'Produit supprimé du panier.';
        exit;
    } else {
        echo 'Produit non trouvé dans le panier.';
        exit;
    }
} else {
    echo 'Données manquantes pour la suppression du produit.';
    exit;
}
