<?php

namespace Service;

use Model\Database;
use Repository\ProductRepository;
use PDO;

include_once __DIR__ . '/../Model/Database.php';
include_once __DIR__ . '/../Repository/ProductRepository.php';

class OrderService
{
    private ?Database $instance;
    private ?PDO $pdo;

    public function __construct()
    {
        $this->instance = Database::getInstance();
        $this->pdo = $this->instance->getConnection();
    }

    public function order($cart): void
    {
        $user_id = $_SESSION['user']['id'];
        $total = 0;

        $productRepository = new ProductRepository();
        $products = $productRepository->findWhereInCart($cart);

        foreach ($products as $product) {
            $total += $product['price'] * $cart[$product['id']];
        }

        $this->pdo->beginTransaction();

        try {
            $stmt = $this->pdo->prepare("INSERT INTO orders (user_id, total) VALUES (?, ?)");
            $stmt->execute([$user_id, $total]);
            $order_id = $this->pdo->lastInsertId();

            $stmt = $this->pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
            foreach ($products as $product) {
                $stmt->execute([$order_id, $product['id'], $cart[$product['id']], $product['price']]);
            }

            $this->pdo->commit();
            unset($_SESSION['cart']);
            header('Location: /order/success');
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            echo "Erreur lors de la commande: " . $e->getMessage();
        }
    }
}