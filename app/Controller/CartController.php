<?php

namespace Controller;

use Framework\AbstractController;
use Repository\ProductRepository;

include_once __DIR__ . '/../vendor/Framework/AbstractController.php';
include_once __DIR__ . '/../Repository/ProductRepository.php';

class CartController extends AbstractController
{
    public function cart(): string
    {
        $cart = $_SESSION['cart'] ?? [];
        $products = [];
        $total = 0;

        if (!empty($cart)) {
            $productRepository = new ProductRepository();
            $fetchedProducts = $productRepository->findWhereInCart($cart);

            foreach ($fetchedProducts as $key => $product) {
                $quantity = $cart[$product['id']];
                $total_price = $product['price'] * $quantity;

                $fetchedProducts[$key]['quantity'] = $quantity;
                $fetchedProducts[$key]['total_price'] = $total_price;

                $total += $total_price;
            }

            $products = $fetchedProducts;
        }

        return $this->render('cart', [
            'products' => $products,
            'total' => $total
        ]);
    }

    public function addItemToCart($request): string
    {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $product_id = $request['product_id'];

        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]++;
        } else {
            $_SESSION['cart'][$product_id] = 1;
        }

        header('Location: /');
        exit();
    }

    public function removeItemToCart($request): void
    {
        if (isset($request['productId'])) {
            $product_id = $request['productId'];

            if (isset($_SESSION['cart'][$product_id])) {
                unset($_SESSION['cart'][$product_id]);

                echo 'Produit supprimé du panier.';
            } else {
                echo 'Produit non trouvé dans le panier.';
            }
        } else {
            echo 'Données manquantes pour la suppression du produit.';
        }
    }

    public function updateItemToCart($request): void
    {
        if (isset($request['productId']) && isset($request['quantity'])) {
            $product_id = $request['productId'];
            $quantity = $request['quantity'];

            $quantity = max(0, intval($quantity));

            if (isset($_SESSION['cart'][$product_id])) {
                $_SESSION['cart'][$product_id] = $quantity;

                echo 'Panier mis à jour avec succès.';
            } else {
                echo 'Produit non trouvé dans le panier.';
            }
        } else {
            echo 'Données manquantes pour la mise à jour du panier.';
        }
    }
}
