<?php

declare(strict_types = 1);

namespace App\Models\System;

/**
 * @property-read ?array $db
 */
class Config
{
  protected array $config = [];

  public function __construct(array $env)
  {
    $this->config = [
      'app' => [
        'url'     => $env['APP_URL'],
        'name'     => $env['APP_NAME'],
      ],
      'db' => [
        'host'     => $env['DB_SERVER_NAME'],
        'user'     => $env['DB_USERNAME'],
        'pass'     => $env['DB_PASSWORD'],
        'database' => $env['DB_DATABASE'],
        'port'     => $env['DB_PORT'],
        'driver'   => $env['DB_CONNECTION'],
      ],
      'db_local' => [
        'host'     => $env['DB_LOCAL_SERVER'],
        'user'     => $env['DB_USERNAME'],
        'pass'     => $env['DB_PASSWORD'],
        'database' => $env['DB_DATABASE'],
        'port'     => $env['DB_PORT'],
        'driver'   => $env['DB_CONNECTION'],
      ],
      'email' => [
        'mailer'   => $env['MAIL_MAILER'],
        'host'     => $env['MAIL_HOST'],
        'user'     => $env['MAIL_USERNAME'],
        'pass'     => $env['MAIL_PASSWORD'],
        'port'     => $env['MAIL_PORT'],
        'encrypt'  => $env['MAIL_ENCRYPTION'],
        'from'     => $env['MAIL_FROM_ADDRESS'],
        'name'     => $env['MAIL_FROM_NAME'],
      ],
    ];
  }

  public function __get(string $name)
  {
    return $this->config[$name] ?? null;
  }
}