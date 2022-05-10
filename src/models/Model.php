<?php

namespace App\Model;

use App\Connection\Connection;
use PDO;

class Model
{
    public function __construct($data)
    {
    }

    public function getProperties(): array
    {
        return get_object_vars($this);
    }

    public function create(array $data, string $table)
    {
        $keyDB = "";
        foreach ($data as $key => $value) {
            $keyDB .= ":" . $key . ",";
        }
        $keyDB = substr($keyDB, 0, -1);
        $key = implode(",", array_keys($data));

        $stmt = Connection::getInstance()->prepare("INSERT INTO {$table} ({$key}) VALUES ({$keyDB})");
        $stmt->execute($data);
        if($stmt->rowCount() > 0) {
            echo "saved register in {$table}" . PHP_EOL;
        };
    }

    public function findByTerm(array $data, string $table, string $terms, string $params)
    {
        $stmt = Connection::getInstance()->prepare("SELECT * FROM {$table} WHERE {$terms} = ?;");
        $stmt->execute(array($params));

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findAll(array $data, string $table)
    {
        $stmt = Connection::getInstance()->prepare("SELECT * FROM {$table}");

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
