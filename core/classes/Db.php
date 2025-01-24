<?php

namespace Makler;

class Db
{
    private static $instance = null;

    private \PDO $connection;
    private string $dsn;
    private string $username;
    private string $password;
    private array $options;


    public static function getInstance($config): Db
    {
        if (self::$instance == null) {
            self::$instance = new Self($config);
        }
        return self::$instance;
    }


    private function __construct(array $config)
    {
        $this->dsn = $config['dsn'];
        $this->username = $config['username'];
        $this->password = $config['password'];
        $this->options = $config['options'] ?? [
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_PERSISTENT => false
        ];
        $this->connect();
    }

    private function connect(): void
    {
        try {
            $this->connection = new \PDO($this->dsn, $this->username, $this->password, $this->options);
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
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
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

    private function __clone()
    {

    }

    public function __wakeup()
    {
    }
}