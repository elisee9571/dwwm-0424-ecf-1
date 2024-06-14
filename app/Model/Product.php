<?php

namespace Model;

class Product
{
    private $id;
    private $name;
    private $price;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): Product
    {
        $this->id = $id;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name): Product
    {
        $this->name = $name;
        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }
}
