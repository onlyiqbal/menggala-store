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
    $user->name = "budi";
    $user->email = "tes@gmail.com";
    $user->username = "budi";
    $user->password = "qwerty123";
    $user->address = "jl.bersama";
    $user->no_hp = "081234567451";
    $user->status = "user";

    $this->userRepository->save($user);

    $result = $this->userRepository->findByNoHp($user->no_hp);

    $this->assertSame($user->name, $result->name);
    $this->assertSame($user->username, $result->username);
    $this->assertSame($user->password, $result->password);
  }

  public function testFindByNoHpNotFound()
  {
    $user = $this->userRepository->findByNoHp(2);

    $this->assertNull($user);
  }
}
