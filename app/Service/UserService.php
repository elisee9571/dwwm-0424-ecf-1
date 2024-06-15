<?php

namespace Service;

use Model\Database;
use Model\User;
use PDO;

include_once __DIR__ . '/../Model/Database.php';

class UserService
{
    private ?Database $instance;
    private ?PDO $pdo;

    public function __construct()
    {
        $this->instance = Database::getInstance();
        $this->pdo = $this->instance->getConnection();
    }

    public function register(User $user)
    {
        try {
            $query = 'INSERT INTO users (email, firstname, name, password) VALUES (:email, :firstname, :name, :password)';

            $stmt = $this->pdo->prepare($query);

            $email = $user->getEmail();
            $firstname = $user->getFirstname();
            $name = $user->getName();
            $password = password_hash($user->getPassword(), PASSWORD_DEFAULT);

            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':firstname', $firstname);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':password', $password);

            if ($stmt->execute()) {
                return true;
            }

            return false;
        } catch (\PDOException $exception) {
            echo $exception->getMessage();
        }
    }

    public function login(User $user)
    {
        try {
            $query = 'SELECT id, email, password FROM users WHERE email = :email';

            $stmt = $this->pdo->prepare($query);

            $email = $user->getEmail();
            $stmt->bindParam(':email', $email);

            $stmt->execute();

            $logger = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($logger && password_verify($user->getPassword(), $logger['password'])) {
                $_SESSION['user'] = $logger;
                return true;
            }

            return false;
        } catch (\PDOException $exception) {
            echo $exception->getMessage();
        }
    }
}