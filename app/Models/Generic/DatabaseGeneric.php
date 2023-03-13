<?php

declare(strict_types = 1);

namespace App\Models\Generic;

use PDO;

/**
 * @mixin PDO
 */
class DatabaseGeneric
{
    private PDO $pdo;

    public function __construct(array $config)
    {
        $defaultOptions = [
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        try
        {
          // $this->pdo = new PDO(
          //     $config['driver'] . ':host=' . $config['host'] . ';dbname=' . $config['database'],
          //     $config['user'],
          //     $config['pass'],
          //     $config['options'] ?? $defaultOptions
          // );
          $this->connString = "mysql:host=".$config['host'].':'.$config['port'].";dbname=".$config['database'];
          $this->pdo = new PDO($this->connString, $config['user'], $config['pass']);
          $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
    }

    public function __call(string $name, array $arguments)
    {
        return call_user_func_array([$this->pdo, $name], $arguments);
    }
}