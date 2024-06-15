<?php

namespace Controller;

use Repository\OrderRepository;
use Service\OrderService;

include_once __DIR__ . '/../vendor/Framework/AbstractController.php';
include_once __DIR__ . '/../Service/OrderService.php';
include_once __DIR__ . '/../Repository/OrderRepository.php';

class OrderController extends \AbstractController
{
    private OrderService $orderService;

    public function __construct()
    {
        $this->orderService = new OrderService();
    }

    public function order(): string
    {
        if (!isset($_SESSION['user']['id'])) {
            header('Location: /login');
            exit;
        }

        $cart = $_SESSION['cart'] ?? [];

        if (empty($cart)) {
            header('Location: /cart');
            exit;
        }

        $this->orderService->order($cart);

        return $this->render('order');
    }

    public function orders(): string
    {
        $orderRepository = new OrderRepository();
        $orders = $orderRepository->findByUser();

        return $this->render('orders', [
            'orders' => $orders
        ]);
    }

    public function success(): string
    {
        return $this->render('order_success');
    }
}
