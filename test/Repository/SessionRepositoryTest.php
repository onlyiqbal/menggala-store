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
    $session->session_id = uniqid();
    $session->user_id = "28";
    $this->sessionRepository->save($session);

    $result = $this->sessionRepository->findById($session->session_id);

    $this->assertEquals($session->session_id, $result->session_id);
    $this->assertEquals($session->user_id, $result->user_id);
  }

  public function testDeleteByIdSuccess()
  {
    $session = new Session();
    $session->session_id = uniqid();
    $session->user_id = "30";
    $this->sessionRepository->save($session);

    $result = $this->sessionRepository->findById($session->session_id);

    $this->assertEquals($session->session_id, $result->session_id);
    $this->assertEquals($session->user_id, $result->user_id);

    $this->sessionRepository->deleteById($session->session_id);
    $result = $this->sessionRepository->findById($session->session_id);

    $this->assertNull($result);
  }
}
