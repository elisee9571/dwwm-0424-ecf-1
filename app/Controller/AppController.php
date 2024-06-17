<?php

namespace Controller;

use Framework\AbstractController;

include_once __DIR__ . '/../vendor/Framework/AbstractController.php';

class AppController extends AbstractController
{
    public function home(): string
    {
        return $this->render('home');
    }
}