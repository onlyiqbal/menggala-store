<?php

namespace Iqbal\MenggalaStore\Repository;

use Iqbal\MenggalaStore\Domain\Session;
use PDO;

class SessionRepository
{
  private PDO $connection;

  public function __construct(PDO $connection)
  {
    $this->connection = $connection;
  }

  public function save(Session $session): Session
  {
    $statement = $this->connection->prepare("INSERT INTO sessions(session_id, user_id) VALUES (?, ?)");
    $statement->execute([$session->session_id, $session->user_id]);

    return $session;
  }

  public function findById(string $session_id): ?Session
  {
    $statement = $this->connection->prepare("SELECT session_id, user_id FROM sessions WHERE session_id = ?");
    $statement->execute([$session_id]);

    try {
      if ($row = $statement->fetch()) {
        $session = new Session();
        $session->session_id = $row['session_id'];
        $session->user_id = $row['user_id'];

        return $session;
      } else {
        return null;
      }
    } finally {
      $statement->closeCursor();
    }
  }

  public function deleteById(string $session_id): void
  {
    $statement = $this->connection->prepare("DELETE FROM sessions WHERE session_id = ?");
    $statement->execute([$session_id]);
  }

  public function deleteAll(): void
  {
    $this->connection->exec("DELETE FROM sessions");
  }
}
