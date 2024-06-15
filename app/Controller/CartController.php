<?php

namespace Controller;

include_once __DIR__ . '/../vendor/Framework/AbstractController.php';

class CartController extends \AbstractController
{
    public function cart(): string
    {
        return $this->render('cart');
    }

    public function addItemToCart(): string
    {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $product_id = $_POST['product_id'];

        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]++;
        } else {
            $_SESSION['cart'][$product_id] = 1;
        }

        header('Location: /cart');

//        return $this->render('cart');
    }

    public function removeItemToCart(): string
    {
        return $this->render('cart');
    }

    public function updateItemToCart(): string
    {
        return $this->render('cart');
    }
}
