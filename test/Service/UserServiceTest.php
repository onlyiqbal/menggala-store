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
    $request->username = "budianduk";
    $request->password = "qwerty123";

    $response = $this->userService->register($request);

    $this->assertEquals($request->name, $response->user->name);
    $this->assertEquals($request->no_hp, $response->user->no_hp);
  }

  public function testRegisterFailed()
  {
    $this->expectException(ValidationException::class);

    $request = new UserRegisterRequest();
    $request->name = "";
    $request->email = "";
    $request->no_hp = "";
    $request->address = "";
    $request->username = "";
    $request->password = "";

    $this->userService->register($request);
  }

  public function testRegisterDuplicate()
  {
    $user = new User();
    $user->name = "budi";
    $user->email = "tes@gmail.com";
    $user->username = "budianduk";
    $user->password = "qwerty123";
    $user->address = "jl.bersama";
    $user->no_hp = "081234567451";
    $user->status = "user";

    $this->userRepository->save($user);
    $this->expectException(ValidationException::class);

    $request = new UserRegisterRequest();
    $request->name = "budi";
    $request->email = "budi@gmail.com";
    $request->no_hp = "081234567451";
    $request->address = "jl.ampera";
    $request->username = "budianduk";
    $request->password = "qwerty123";

    $this->userService->register($request);
  }

  public function testLoginSuccess()
  {
    $request = new UserRegisterRequest();
    $request->name = "budi";
    $request->email = "budi@gmail.com";
    $request->no_hp = "089254678312";
    $request->address = "jl.ampera";
    $request->username = "budianduk";
    $request->password = "qwerty123";

    $response = $this->userService->register($request);

    $request = new UserLoginRequest();
    $request->username = "budianduk";
    $request->password = "qwerty123";

    $response = $this->userService->login($request);

    $this->assertEquals($request->username, $response->user->username);
    $this->assertTrue(password_verify($request->password, $response->user->password));
  }

  public function testLoginNotFound()
  {
    $this->expectException(ValidationException::class);

    $request = new UserLoginRequest();
    $request->username = "budianduk";
    $request->password = "qwerty123";

    $this->userService->login($request);
  }

  public function testLoginPasswordWrong()
  {
    $request = new UserRegisterRequest();
    $request->name = "budi";
    $request->email = "budi@gmail.com";
    $request->no_hp = "089254678312";
    $request->address = "jl.ampera";
    $request->username = "budianduk";
    $request->password = "qwerty123";

    $this->userService->register($request);

    $this->expectException(ValidationException::class);

    $request = new UserLoginRequest();
    $request->username = "budianduk";
    $request->password = "salah";

    $this->userService->login($request);
  }
}
