<?php

declare(strict_types=1);

class UpdateModel
{

  private Database $db;
  private int $userID;

  public function __construct(Database $db, int $userID)
  {

    $this->db = $db;
    $this->userID = $userID;

  }

  public function ScanLobbyGames() : array
  {
    $stmt = $this->db->conn->prepare("SELECT uniqueIndex,
    lastMoved,
    gameTurn,
    gameCompleted,
    gameResult
    FROM chess_games
    WHERE gameCompleted='0'
    AND ( whiteID =:qWhite OR blackID=:qBlack )
    AND ( whiteID !=:qLobby1 AND blackID!=:qLobby2 )
    AND hiddenRow='0'");

    $user = (int)$this->userID;
    $lobby = -2;

    $stmt->bindParam(':qWhite', $user);
    $stmt->bindParam(':qBlack', $user);

    $stmt->bindParam(':qLobby1', $lobby);
    $stmt->bindParam(':qLobby2', $lobby);

    $stmt->execute();
    $result = $stmt->fetchAll();

    return $result;
  }

  public function ScanLobbyLobby() : array
  {
    $stmt = $this->db->conn->prepare("SELECT uniqueIndex,
    lastMoved,
    gameTurn,
    gameCompleted,
    gameResult
    FROM chess_games
    WHERE gameCompleted='0'
    AND ( whiteID =:qLobby1 OR blackID=:qLobby2 )
    AND hiddenRow='0'");

    $openChallenge = -2;

    $stmt->bindParam(':qLobby1', $openChallenge);
    $stmt->bindParam(':qLobby2', $openChallenge);

    $stmt->execute();
    $result = $stmt->fetchAll();

    return $result;
  }
}