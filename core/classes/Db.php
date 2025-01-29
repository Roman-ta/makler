<?php

namespace Makler;

use PDO;

class Db
{
    private static $instance = null;

    private PDO $connection;
    private string $dsn = 'mysql:host=localhost;dbname=makler';
    private string $username = 'root';
    private string $password = '';
    private array $options;



    public static function getInstance(): Db
    {
        if (self::$instance == null) {
            self::$instance = new Self();
        }
        return self::$instance;
    }


    private function __construct()
    {
        $this->options = $config['options'] ?? [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_PERSISTENT => false
        ];
        $this->connect();
    }

    private function connect(): void
    {
        try {
            $this->connection = new PDO($this->dsn, $this->username, $this->password, $this->options);
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    private function query(string $sql, array $params = []): \PDOStatement
    {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function update(string $sql, array $params = []): void
    {
        try {
            $this->query($sql, $params);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage());
        }
    }

    public function row(string $sql, array $params = []): array
    {
        return $this->query($sql, $params)->fetch();
    }

    public function rows(string $sql, array $params = []): array
    {
        return $this->query($sql, $params)->fetchAll();
    }
    public function insert(string $table, array $params): void
    {
        $rows = implode(", ", array_keys($params));

        $placeholders = implode(', ', array_map(fn($col) => ":$col", array_keys($params)));
        $sql = "INSERT INTO {$table} ({$rows}) VALUES ({$placeholders})";
        $this->query($sql, $params);
    }
    private function __clone()
    {

    }

    public function __wakeup()
    {
    }
}