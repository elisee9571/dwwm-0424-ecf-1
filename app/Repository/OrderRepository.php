<?php

namespace Repository;

use Model\Database;
use Model\Product;
use PDO;

include_once __DIR__ . '/../Model/Product.php';
include_once __DIR__ . '/../Model/Database.php';

class OrderRepository
{
    private ?Database $instance;
    private ?PDO $pdo;

    public function __construct()
    {
        $this->instance = Database::getInstance();
        $this->pdo = $this->instance->getConnection();
    }

    function findByUser(): array
    {
        if (!isset($_SESSION['user']['id'])) {
            return [];
        }

        $query = '
            SELECT 
                o.id as order_id, 
                o.total as total, 
                o.created_at as created_at,
                oi.id as order_item_id, 
                oi.product_id, 
                oi.quantity, 
                oi.price as item_price, 
                p.name as product_name, 
                p.price as product_price
            FROM orders o
            JOIN order_items oi ON o.id = oi.order_id
            JOIN products p ON oi.product_id = p.id
            WHERE o.user_id = :userId
            ORDER BY o.id DESC;
        ';

        $stmt = $this->pdo->prepare($query);
        $userId = $_SESSION['user']['id'];
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $orders = [];
        foreach ($results as $row) {
            $orderId = $row['order_id'];
            if (!isset($orders[$orderId])) {
                $orders[$orderId] = [
                    'order_id' => $row['order_id'],
                    'total' => $row['total'],
                    'created_at' => $row['created_at'],
                    'items' => []
                ];
            }
            $orders[$orderId]['items'][] = [
                'order_item_id' => $row['order_item_id'],
                'product_id' => $row['product_id'],
                'quantity' => $row['quantity'],
                'item_price' => $row['item_price'],
                'product_name' => $row['product_name'],
                'product_price' => $row['product_price']
            ];
        }

        return array_values($orders);
    }
}
