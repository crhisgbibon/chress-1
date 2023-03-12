<?php

declare(strict_types=1);

/** Model Class
 * 
 * 
 * 
*/

class ListModel
{

  private Database $db;
  private int $userID;

  public function __construct(Database $db, int $userID)
  {

    $this->db = $db;
    $this->userID = $userID;

  }

  public function GetLists() : array
  {
    $output = [];

    $stmt = $this->db->conn->prepare("SELECT DISTINCT `event` FROM chess_pgn");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_COLUMN);
    array_push($output, $result);

    $stmt = $this->db->conn->prepare("SELECT DISTINCT `site` FROM chess_pgn");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_COLUMN);
    array_push($output, $result);

    $stmt = $this->db->conn->prepare("SELECT DISTINCT `date` FROM chess_pgn");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_COLUMN);
    array_push($output, $result);

    $stmt = $this->db->conn->prepare("SELECT DISTINCT `round` FROM chess_pgn");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_COLUMN);
    array_push($output, $result);

    $stmt = $this->db->conn->prepare("SELECT DISTINCT `white` FROM chess_pgn");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_COLUMN);
    array_push($output, $result);
    
    $stmt = $this->db->conn->prepare("SELECT DISTINCT `black` FROM chess_pgn");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_COLUMN);
    array_push($output, $result);
    
    $stmt = $this->db->conn->prepare("SELECT DISTINCT `result` FROM chess_pgn");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_COLUMN);
    array_push($output, $result);

    return $output;
  }

}