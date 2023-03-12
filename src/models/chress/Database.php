<?php

declare(strict_types=1);

/** Database Class
 * 
 * 
 * 
*/

class Database
{

  private string $servername;
  private string $username;
  private string $password;
  private string $database;

  private string $connString;
  public PDO $conn;

  public function __construct(Config $config)
  {

    $this->servername = $config->GetServerName();
    $this->username = $config->GetUsername();
    $this->password = $config->GetPassword();
    $this->database = $config->GetDatabase();

    $serve = $this->servername;

    $this->connString = "mysql:host=$serve;dbname=".$this->database."";
    $this->conn = new PDO($this->connString, $this->username, $this->password);
    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  }
}