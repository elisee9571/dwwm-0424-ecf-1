<?php

namespace Model;

use PDO;
use PDOException;

class Database
{
    private $dsn = 'mysql:host=mysql;dbname=database';
    private $username = 'root';
    private $password = 'paris';

    public function connect()
    {
        $conn = null;

        try {
            $conn = new PDO($this->dsn, $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }

        return $conn;
    }
}

