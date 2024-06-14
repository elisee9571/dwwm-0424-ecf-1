<?php

namespace Repository;

use Model\Product;
use PDO;

class ProductRepository
{
    private $conn;
    private $table_name = 'products';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    function findAll(): array
    {
        $query = 'SELECT * FROM ' . $this->table_name;

        $stmt = $this->conn->prepare($query);

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
}