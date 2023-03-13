<?php

declare(strict_types = 1);

namespace App\Models\Generic;

/**
 * @property-read ?array $db
 */
class Config
{
    protected array $config = [];

    public function __construct(array $env)
    {
        $this->config = [
            'db' => [
                'host'     => $env['DB_SERVER_NAME'],
                'user'     => $env['DB_USERNAME'],
                'pass'     => $env['DB_PASSWORD'],
                'database' => $env['DB_DATABASE'],
                'port'     => $env['DB_PORT'],
                'driver'   => $env['DB_CONNECTION'] ?? 'mysql',
            ],
            'email' => [
              'host'     => $env['MAIL_HOST'],
              'user'     => $env['MAIL_USERNAME'],
              'pass'     => $env['MAIL_PASSWORD'],
          ],
        ];
    }

    public function __get(string $name)
    {
        return $this->config[$name] ?? null;
    }
}