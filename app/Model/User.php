<?php

namespace Model;

use vendor\UserBundle\AbstractUser;

include_once __DIR__ . '/../vendor/UserBundle/AbstractUser.php';
include_once __DIR__ . '/Database.php';

class User extends AbstractUser
{
    private int $id;
    private string $firstname;
    private string $lastname;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId($id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname($firstname): self
    {
        $this->firstname = $firstname;
        return $this;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname($lastname): self
    {
        $this->lastname = $lastname;
        return $this;
    }

    public function login()
    {
        // TODO: Implement login() method.
    }

    public function register()
    {
        try {
            $instance = Database::getInstance();
            $pdo = $instance->getConnection();
            $query = 'INSERT INTO users (email, firstname, lastname, password) VALUES (:email, :firstname, :lastname, :password)';

            $stmt = $pdo->prepare($query);

            $email = $this->getEmail();
            $firstname = $this->getFirstname();
            $lastname = $this->getLastname();
            $password = password_hash($this->getPassword(), PASSWORD_DEFAULT);

            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':firstname', $firstname);
            $stmt->bindParam(':lastname', $lastname);
            $stmt->bindParam(':password', $password);

            if ($stmt->execute()) {
                return true;
            }

            return false;
        } catch (\PDOException $exception) {
            echo $exception->getMessage();
        }
    }
}
