<?php

namespace Iqbal\MenggalaStore\Repository;

use Iqbal\MenggalaStore\Config\Database;
use Iqbal\MenggalaStore\Domain\Session;
use Iqbal\MenggalaStore\Domain\User;
use PHPUnit\Framework\TestCase;

class SessionRepositoryTest extends TestCase
{
  private SessionRepository $sessionRepository;
  private UserRepository $userRepository;

  protected function setUp(): void
  {
    $this->sessionRepository = new SessionRepository(Database::getConnection());
    $this->sessionRepository->deleteAll();

    $this->userRepository = new UserRepository(Database::getConnection());
    $this->userRepository->deleteAll();

    $user = new User();
    $user->name = "budi";
    $user->email = "budi@gmail.com";
    $user->no_hp = "081254327865";
    $user->address = "jl.ampera";
    $user->username = "budianduk";
    $user->password = "qwerty";
    $this->userRepository->save($user);
  }

  public function testSaveSuccess()
  {
    $session = new Session();
    $session->id = uniqid();
    $session->user_id = "25";

    $this->sessionRepository->save($session);
    $result = $this->sessionRepository->findById($session->id);

    $this->assertEquals($session->id, $result->id);
    $this->assertEquals($session->user_id, $result->user_id);
  }
}
