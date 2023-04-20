<?php

namespace Iqbal\MenggalaStore\Repository;

use Iqbal\MenggalaStore\Domain\User;
use PDO;

class UserRepository
{
  private PDO $connection;

  public function __construct(PDO $connection)
  {
    $this->connection = $connection;
  }

  public function save(User $user): User
  {
    $statement = $this->connection->prepare("INSERT INTO users(name, email, username, password, address, no_hp, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $statement->execute([$user->name, $user->email, $user->username, $user->password, $user->address, $user->no_hp, $user->status]);

    return $user;
  }

  public function findByNoHp(string $no_hp): ?User
  {
    $statement = $this->connection->prepare("SELECT id, name, email, username, password, address, no_hp, status FROM users WHERE no_hp = ?");
    $statement->execute([$no_hp]);

    try {
      if ($row = $statement->fetch()) {
        $user = new User();
        $user->id = $row['id'];
        $user->name = $row['name'];
        $user->email = $row['email'];
        $user->username = $row['username'];
        $user->password = $row['password'];
        $user->address = $row['address'];
        $user->no_hp = $row['no_hp'];
        $user->status = $row['status'];

        return $user;
      } else {
        return null;
      }
    } finally {
      $statement->closeCursor();
    }
  }

  public function deleteAll(): void
  {
    $this->connection->exec("DELETE FROM users");
  }
}
