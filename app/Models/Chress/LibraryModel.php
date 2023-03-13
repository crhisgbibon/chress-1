<?php

declare(strict_types=1);

namespace App\Models\Chress;

class LibraryModel
{

  private Database $db;
  private int $userID;

  public function __construct(Database $db, int $userID)
  {

    $this->db = $db;
    $this->userID = $userID;

  }

  public function GetPGNList(array $data) : array
  {
    $stmt = $this->db->conn->prepare("SELECT `rank`, `event`, `site`, `date`, `round`, `white`, `black`, `result` FROM chess_pgn
    WHERE `rank`=:qRank");

    $output = [];

    $len = count($data);

    for($i = 0; $i < $len; $i++)
    {
      $stmt->bindParam(':qRank', $data[$i]);

      $stmt->execute();

      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      array_push($output, $result);
    }

    return $output;
  }

  public function GetPGN(int $gameID) : string
  {
    $stmt = $this->db->conn->prepare("SELECT game FROM chess_pgn
    WHERE `rank`=:qIndex");

    $stmt->bindParam(':qIndex', $gameID);

    $stmt->execute();

    $game = $stmt->fetchColumn();

    return $game;
  }

  public function GetIndexes(array $data) : array
  {
    if(count($data) !== 9) return [];

    $event = (string)$data[0];
    $site = (string)$data[1];
    $date = (string)$data[2];

    $round = (string)$data[3];
    $white = (string)$data[4];
    $black = (string)$data[5];

    $result = (string)$data[6];

    $flexQuery = $this->GenerateFlexQuery($data);

    $stmt = $this->db->conn->prepare("SELECT `rank` FROM chess_pgn $flexQuery");

    if($event !== "") $stmt->bindParam(':qEvent', $event);
    if($site !== "") $stmt->bindParam(':qSite', $site);
    if($date !== "") $stmt->bindParam(':qDate', $date);

    if($round !== "") $stmt->bindParam(':qRound', $round);
    if($white !== "") $stmt->bindParam(':qWhite', $white);
    if($black !== "") $stmt->bindParam(':qBlack', $black);

    if($result !== "") $stmt->bindParam(':qResult', $result);

    $stmt->execute();
    $queryResponse = $stmt->fetchAll(PDO::FETCH_COLUMN);

    return $queryResponse;
  }

  public function GetPGNCount(array $data) : array
  {
    $event = (string)$data[0];
    $site = (string)$data[1];
    $date = (string)$data[2];

    $round = (string)$data[3];
    $white = (string)$data[4];
    $black = (string)$data[5];

    $result = (string)$data[6];

    $flexQuery = $this->GenerateFlexQuery($data);

    $stmt = $this->db->conn->prepare("SELECT COUNT(game) FROM chess_pgn $flexQuery");

    if($event !== "") $stmt->bindParam(':qEvent', $event);
    if($site !== "") $stmt->bindParam(':qSite', $site);
    if($date !== "") $stmt->bindParam(':qDate', $date);

    if($round !== "") $stmt->bindParam(':qRound', $round);
    if($white !== "") $stmt->bindParam(':qWhite', $white);
    if($black !== "") $stmt->bindParam(':qBlack', $black);

    if($result !== "") $stmt->bindParam(':qResult', $result);

    $stmt->execute();
    $queryResponse = $stmt->fetchAll(PDO::FETCH_COLUMN);

    return $queryResponse;
  }

  private function GenerateFlexQuery(array $data) : string
  {
    if(count($data) !== 9) return [];

    $event = (string)$data[0];
    $site = (string)$data[1];
    $date = (string)$data[2];

    $round = (string)$data[3];
    $white = (string)$data[4];
    $black = (string)$data[5];

    $result = (string)$data[6];
    $output = (int)$data[7];
    $offset = (int)$data[8];

    if($output > 100) $output = 100;

    $flexQuery = "";

    if($event !== "") $flexQuery = "WHERE `event`=:qEvent ";

    if($site !== "")
    {
      if($event === "") $flexQuery = "WHERE `site`=:qSite ";
      else $flexQuery .= "AND `site`=:qSite ";
    }

    if($date !== "")
    {
      if($event === "" && 
      $site === "") $flexQuery = "WHERE `date`=:qDate ";
      else $flexQuery .= "AND `date`=:qDate ";
    }

    if($round !== "")
    {
      if($event === "" && 
      $site === "" && 
      $date === "") $flexQuery = "WHERE `round`=:qRound ";
      else $flexQuery .= "AND `round`=:qRound ";
    }

    if($white !== "")
    {
      if($event === "" && 
      $site === "" && 
      $date === "" && 
      $round === "") $flexQuery = "WHERE `white`=:qWhite ";
      else $flexQuery .= " AND `white`=:qWhite ";
    }

    if($black !== "")
    {
      if($event === "" && 
      $site === "" && 
      $date === "" && 
      $round === "" && 
      $white === "") $flexQuery = "WHERE `black`=:qBlack ";
      else $flexQuery .= "AND `black`=:qBlack ";
    }

    if($result !== "")
    {
      if($event === "" && 
      $site === "" && 
      $date === "" && 
      $round === "" && 
      $white === "" && 
      $black === "") $flexQuery = "WHERE `result`=:qResult ";
      else $flexQuery .= "AND `result`=:qResult ";
    }

    $cap = $output * $offset;
    
    $flexQuery .= "LIMIT " . $output . " OFFSET " . $cap . ";";

    return $flexQuery;
  }

}