<?php

declare(strict_types=1);

namespace App\Models\Generic;

require_once __DIR__ . '/../../../vendor/autoload.php';

class Config1
{
  private string $servername;
  private string $portNumber;
  private string $username;
  private string $password;

  private string $database_generic;
  private string $database_chess;
  private string $database_chat;
  private string $database_podcasts;
  private string $database_cron;

  private string $email_host;
  private string $email_username;
  private string $email_password;

  public function __construct(array $env)
  {
    $this->servername = $env['DB_SERVER_NAME'];
    $this->portNumber = $env['DB_PORT'];
    $this->database = $env['DB_DATABASE'];
    $this->username = $env['DB_USERNAME'];
    $this->password = $env['DB_PASSWORD'];

    $this->email_host = $env['MAIL_HOST'];
    $this->email_username = $env['MAIL_USERNAME'];
    $this->email_password = $env['MAIL_PASSWORD'];
  }

  public function GetEmailHost()
  {
    return $this->email_host;
  }

  public function GetEmailUsername()
  {
    return $this->email_username;
  }

  public function GetEmailPassword()
  {
    return $this->email_password;
  }

  public function GetServerName()
  {
    return $this->servername;
  }

  public function GetPortNumber()
  {
    return $this->portNumber;
  }

  public function GetUsername()
  {
    return $this->username;
  }

  public function GetPassword()
  {
    return $this->password;
  }

  public function GetDatabase()
  {
    return $this->database;
  }
}