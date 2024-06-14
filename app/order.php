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

$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    header('Location: cart.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$total = 0;

$product_ids = array_keys($cart);
$placeholders = implode(',', array_fill(0, count($product_ids), '?'));
$stmt = $db->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
$stmt->execute($product_ids);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($products as $product) {
    $total += $product['price'] * $cart[$product['id']];
}

$db->beginTransaction();

try {
    $stmt = $db->prepare("INSERT INTO orders (user_id, total) VALUES (?, ?)");
    $stmt->execute([$user_id, $total]);
    $order_id = $db->lastInsertId();

    $stmt = $db->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    foreach ($products as $product) {
        $stmt->execute([$order_id, $product['id'], $cart[$product['id']], $product['price']]);
    }

    $db->commit();
    unset($_SESSION['cart']);
    echo "Commande passée avec succès!";
} catch (Exception $e) {
    $db->rollBack();
    echo "Erreur lors de la commande: " . $e->getMessage();
}
