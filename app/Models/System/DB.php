<?php

declare(strict_types = 1);

namespace App\Models\System;

use PDO;

/**
 * @mixin PDO
 */
class DB
{
  public PDO $pdo;

  public function __construct(array $config)
  {
    $defaultOptions =
    [
      PDO::ATTR_EMULATE_PREPARES   => false,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    try
    {
      $this->pdo = new PDO
      (
        $config['driver'] . ':host=' . $config['host'] . ';dbname=' . $config['database'],
        $config['user'],
        $config['pass'],
        $config['options'] ?? $defaultOptions
      );
      $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(\PDOException $e)
    {
      throw new \PDOException($e->getMessage(), (int) $e->getCode());
    }
  }

  public function __call(string $name, array $arguments)
  {
    return call_user_func_array([$this->pdo, $name], $arguments);
  }
}