<?php

namespace Src\Database;

use PDO;
use PDOException;

final class Database
{
    private PDO|null $connection = null;

    public function __construct()
    {
        $this->initialize();
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }

    private function initialize(): void
    {
        $dbname = getenv('MYSQL_DATABASE');
        $dbhost = getenv('MYSQL_HOST');
        $dbuser = getenv('MYSQL_USER');
        $dbpass = getenv('MYSQL_PASSWORD');

        try {
            $this->connection = new PDO("mysql:host={$dbhost};dbname={$dbname}", $dbuser, $dbpass);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            // TODO: handle pdo exception
        }
    }
}
