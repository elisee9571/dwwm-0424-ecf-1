<?php

namespace Model;

use PDO;

class Database
{
    private static ?Database $instance = null;
    private PDO $pdo;
    private string $host = 'mysql';
    private string $dbname = 'database';
    private string $username = 'user';
    private string $password = 'paris';

    private function __construct()
    {
        $dsn = "mysql:host={$this->host};dbname={$this->dbname}";
        $this->pdo = new PDO($dsn, $this->username, $this->password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstance(): ?Database
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }
}
