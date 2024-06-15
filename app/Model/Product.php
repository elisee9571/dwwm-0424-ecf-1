<?php

namespace Model;

class Product
{
    private int $id;
    private string $name;
    private string $price;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId($id): Product
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName($name): Product
    {
        $this->name = $name;
        return $this;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function setPrice($price): Product
    {
        $this->price = $price;
        return $this;
    }
}
