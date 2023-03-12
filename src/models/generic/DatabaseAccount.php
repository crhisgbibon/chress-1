<?php

declare(strict_types=1);

class DatabaseAccount
{
  private string $servername;
  private string $portNumber;
  private string $username;
  private string $password;
  private string $database;

  private string $connString;
  public PDO $conn;

  public function __construct(Config $config)
  {
    $this->servername = $config->GetServerName();
    $this->portNumber = $config->GetPortNumber();
    $this->username = $config->GetUsername();
    $this->password = $config->GetPassword();
    $this->database = $config->GetDatabase();

    $this->connString = "mysql:host=".$this->servername.";dbname=".$this->database;
    $this->conn = new PDO($this->connString, $this->username, $this->password);
    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }
}