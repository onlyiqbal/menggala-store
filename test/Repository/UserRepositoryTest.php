<?php

namespace Iqbal\MenggalaStore\Repository;

use Iqbal\MenggalaStore\Config\Database;
use Iqbal\MenggalaStore\Domain\User;
use PHPUnit\Framework\TestCase;

class UserRepositoryTest extends TestCase
{
  private UserRepository $userRepository;

  protected function setUp(): void
  {
    $this->userRepository = new UserRepository(Database::getConnection());
    $this->userRepository->deleteAll();
  }

  public function testSaveSuccess()
  {
    $user = new User();
    $user->id = 1;
    $user->name = "budi";
    $user->email = "tes@gmail.com";
    $user->username = "budi";
    $user->password = "qwerty123";
    $user->address = "jl.bersama";
    $user->no_hp = "08xxxxxxx";
    $user->status = "user";

    $this->userRepository->save($user);

    $result = $this->userRepository->findById($user->id);

    $this->assertSame($user->name, $result->name);
    $this->assertSame($user->username, $result->username);
    $this->assertSame($user->password, $result->password);
  }

  public function testFindByIdNotFound()
  {
    $user = $this->userRepository->findById(2);

    $this->assertNull($user);
  }
}
