<?php

declare(strict_types=1);

require_once __DIR__ . '/../../../vendor/autoload.php';

class Config
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

  public function __construct()
  {
    $dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '/../../../');
    $dotenv->load();
    
    $this->servername = getenv('DB_SERVER_NAME');
    $this->portNumber = getenv('DB_PORT');
    $this->database = getenv('DB_DATABASE');
    $this->username = getenv('DB_USERNAME');
    $this->password = getenv('DB_PASSWORD');

    $this->email_host = getenv('MAIL_HOST');
    $this->email_username = getenv('MAIL_USERNAME');
    $this->email_password = getenv('MAIL_PASSWORD');
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