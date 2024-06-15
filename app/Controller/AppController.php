<?php

namespace Controller;

use Repository\ProductRepository;

include_once __DIR__ . '/../vendor/Framework/AbstractController.php';
include_once __DIR__ . '/../Repository/ProductRepository.php';

class AppController extends \AbstractController
{
    public function home(): void
    {
        $productRepository = new ProductRepository();
        $products = $productRepository->findAll();

        $this->render('home', [
            'products' => $products
        ]);
    }
}
