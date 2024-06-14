<?php

namespace Model;

use PDO;

class User
{
    private $conn;
    private $table_name = 'users';

    private $id;
    private $email;
    private $firstname;
    private $name;
    private $password;

    public function __construct($db)
    {
        $this->conn = $db;
    }


    public function getId()
    {
        return $this->id;
    }

    public function setId($id): User
    {
        $this->id = $id;
        return $this;
    }

    public function getEmail()
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
        return $this->name . ' ' . $this->firstname;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function setFirstname($firstname): User
    {
        $this->firstname = $firstname;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name): User
    {
        $this->name = $name;
        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password): User
    {
        $this->password = $password;
        return $this;
    }

    public function register()
    {
        try {
            $query = 'INSERT INTO ' . $this->table_name . ' (email, firstname, name, password) VALUES (:email, :firstname, :name, :password)';

            $stmt = $this->conn->prepare($query);

            $email = $this->getEmail();
            $firstname = $this->getFirstname();
            $name = $this->getName();
            $password = $this->getPassword();

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

    public function login()
    {
        try {
            $query = 'SELECT id, email, password FROM ' . $this->table_name . ' WHERE email = :email';

            $stmt = $this->conn->prepare($query);

            $this->email = htmlspecialchars(strip_tags($this->email));

            $stmt->bindParam(':email', $this->email);

            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $this->id = $row['id'];
                $this->email = $row['email'];
                return true;
            }

            return false;
        } catch (\PDOException $exception) {
            echo $exception->getMessage();
        }
    }
}
