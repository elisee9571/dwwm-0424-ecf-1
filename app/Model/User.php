<?php

namespace Model;

class User
{
    private int $id;
    private string $email;
    private string $firstname;
    private string $lastname;
    private string $password;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId($id): User
    {
        $this->id = $id;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail($email): User
    {
        $this->email = $email;
        return $this;
    }

    public function getFullName(): string
    {
        return $this->lastname . ' ' . $this->firstname;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname($firstname): User
    {
        $this->firstname = $firstname;
        return $this;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname($lastname): User
    {
        $this->lastname = $lastname;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword($password): User
    {
        $this->password = $password;
        return $this;
    }
}
