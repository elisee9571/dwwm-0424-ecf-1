<?php

namespace Controller;

use Framework\AbstractController;
use Repository\ProductRepository;

include_once __DIR__ . '/../vendor/Framework/AbstractController.php';
include_once __DIR__ . '/../Repository/ProductRepository.php';

class AppController extends AbstractController
{
    public function home(): string
    {
        $productRepository = new ProductRepository();
        $products = $productRepository->findAll();

        return $this->render('home', [
            'products' => $products
        ]);
    }
}
