<?php

namespace Iqbal\MenggalaStore\Service;

use Iqbal\MenggalaStore\Config\Database;
use Iqbal\MenggalaStore\Model\UserRegisterRequest;
use Iqbal\MenggalaStore\Repository\UserRepository;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
  private UserService $userService;
  private UserRepository $userRepository;

  protected function setUp(): void
  {
    $connection = Database::getConnection();
    $this->userRepository = new UserRepository($connection);
    $this->userService = new UserService($this->userRepository);
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
}
