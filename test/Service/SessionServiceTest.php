<?php

namespace Iqbal\MenggalaStore\Service;

require_once __DIR__ . "/../Helper/helper.php";

use Firebase\JWT\JWT;
use Iqbal\MenggalaStore\Config\Database;
use Iqbal\MenggalaStore\Domain\Session;
use Iqbal\MenggalaStore\Domain\User;
use Iqbal\MenggalaStore\Repository\SessionRepository;
use Iqbal\MenggalaStore\Repository\UserRepository;
use PHPUnit\Framework\TestCase;

class SessionServiceTest extends TestCase
{
  private SessionRepository $sessionRepository;
  private SessionService $sessionService;
  private UserRepository $userRepository;

  protected function setUp(): void
  {
    $this->sessionRepository = new SessionRepository(Database::getConnection());
    $this->sessionService = new SessionService($this->sessionRepository);
    $this->userRepository = new UserRepository(Database::getConnection());
    $this->sessionRepository->deleteAll();
    $this->userRepository->deleteAll();


    $user = new User();
    $user->name = "budi";
    $user->email = "budi@gmail.com";
    $user->no_hp = "089612345672";
    $user->address = "jl.ampera";
    $user->username = "budianduk";
    $user->password = "qwerty123";

    $this->userRepository->save($user);
  }

  public function testCreateSession()
  {
    $session = $this->sessionService->create("59");

    $payload = [
      'session_id' => $session->session_id,
      'username' => $session->user_id,
      'role' => 'user',
    ];

    $jwt = JWT::encode($payload, $this->sessionService::$SECRET_KEY, 'HS256');

    $this->expectOutputRegex("[X-MENGGALA-SESSION: $jwt]");

    $result = $this->sessionRepository->findById($session->session_id);

    $this->assertEquals($session->session_id, $result->session_id);
    $this->assertEquals($session->user_id, $result->user_id);
  }

  public function testDestroySession()
  {
    $session = new Session();
    $session->session_id = uniqid();
    $session->user_id = "60";
    $this->sessionRepository->save($session);

    $payload = [
      'session_id' => $session->session_id,
      'username' => $session->user_id,
      'role' => 'user'
    ];

    $jwt = JWT::encode($payload, $this->sessionService::$SECRET_KEY, 'HS256');

    $_COOKIE[$this->sessionService::$COOKIE_NAME] = $jwt;

    $this->sessionService->destroy($session->session_id);

    $this->expectOutputRegex('[X-MENGGALA-SESSION: ]');

    $result = $this->sessionRepository->findById($session->session_id);

    $this->assertNull($result);
  }
}
