<?php

namespace Iqbal\MenggalaStore\Service;

use Iqbal\MenggalaStore\Config\Database;
use Iqbal\MenggalaStore\Domain\User;
use Iqbal\MenggalaStore\Exception\ValidationException;
use Iqbal\MenggalaStore\Model\UserLoginRequest;
use Iqbal\MenggalaStore\Model\UserRegisterRequest;
use Iqbal\MenggalaStore\Repository\SessionRepository;
use Iqbal\MenggalaStore\Repository\UserRepository;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
  private UserService $userService;
  private UserRepository $userRepository;
  private SessionRepository $sessionRepository;

  protected function setUp(): void
  {
    $connection = Database::getConnection();
    $this->userRepository = new UserRepository($connection);
    $this->sessionRepository = new SessionRepository($connection);
    $this->userService = new UserService($this->userRepository);
    $this->sessionRepository->deleteAll();
    $this->userRepository->deleteAll();
  }

  public function testRegisterSuccess()
  {
    $request = new UserRegisterRequest();
    $request->name = "budi";
    $request->email = "budi@gmail.com";
    $request->no_hp = "089254678312";
    $request->address = "jl.ampera";
    $request->username = "budi anduk";
    $request->password = "qwerty123";

    $response = $this->userService->register($request);

    $this->assertEquals($request->name, $response->user->name);
    $this->assertEquals($request->no_hp, $response->user->no_hp);
  }

  public function testLoginSuccess()
  {
    $user = new User();
    $user->name = "budi";
    $user->email = "budi@gmail.com";
    $user->no_hp = "089478582912";
    $user->address = "jl.dulu aja";
    $user->username = "budianduk";
    $user->password = password_hash("qwerty123", PASSWORD_BCRYPT);

    $this->expectException(ValidationException::class);

    $request = new UserLoginRequest();
    $request->username = "budianduk";
    $request->password = "qwerty123";

    $response = $this->userService->login($request);

    $this->assertEquals($request->username, $response->user->username);
    $this->assertTrue($request->password, $response->user->password);
  }
}
