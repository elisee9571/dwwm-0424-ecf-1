<?php

namespace Repository;

use Model\Database;
use Model\Product;
use PDO;

include_once __DIR__ . '/../Model/Product.php';
include_once __DIR__ . '/../Model/Database.php';

class ProductRepository
{
    private ?Database $instance;
    private ?PDO $pdo;

    public function __construct()
    {
        $this->instance = Database::getInstance();
        $this->pdo = $this->instance->getConnection();
    }

    function findAll(): array
    {
        $query = 'SELECT * FROM products';

        $stmt = $this->pdo->prepare($query);

        $stmt->execute();

        $products = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $product = new Product();
            $product->setId($row['id']);
            $product->setName($row['name']);
            $product->setPrice($row['price']);
            $products[] = $product;
        }

        return $products;
    }

    function findWhereInCart($cart): false|array
    {
        $product_ids = array_keys($cart);
        $placeholders = implode(',', array_fill(0, count($product_ids), '?'));
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
        $stmt->execute($product_ids);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}