<?php

namespace Iqbal\MenggalaStore\Controller;

require_once __DIR__ . "/../Helper/helper.php";

use Iqbal\MenggalaStore\Config\Database;
use Iqbal\MenggalaStore\Domain\User;
use Iqbal\MenggalaStore\Repository\UserRepository;
use PHPUnit\Framework\TestCase;

class UserControllerTest extends TestCase
{
  public UserController $userController;
  public UserRepository $userRepository;

  protected function setUp(): void
  {
    $this->userController = new UserController();
    $this->userRepository = new UserRepository(Database::getConnection());
    $this->userRepository->deleteAll();

    putenv("mode=test");
  }

  public function testRegister()
  {
    $this->userController->register();

    $this->expectOutputRegex("[DAFTAR AKUN]");
    $this->expectOutputRegex("[Register Akun]");
    $this->expectOutputRegex("[DAFTAR]");
    $this->expectOutputRegex("[kembali]");
  }

  public function testPostRegister()
  {
    $_POST['name'] = 'budi';
    $_POST['email'] = 'budi@gmail.com';
    $_POST['no_hp'] = '089456743214';
    $_POST['address'] = 'jl.dulu ga sih';
    $_POST['username'] = 'budiajah';
    $_POST['password'] = 'qwerty123';

    $this->userController->postRegister();

    $this->expectOutputRegex('[Location: /login]');
  }

  public function testRegisterUserDuplicate()
  {
    $user = new User();
    $user->name = "budi";
    $user->email = "budi@gmail.com";
    $user->username = "budi";
    $user->password = "qwerty123";
    $user->address = "jl.dulu ga sih";
    $user->no_hp = "081234567451";
    $user->status = "user";

    $this->userRepository->save($user);

    $_POST['name'] = 'budi';
    $_POST['email'] = 'budi@gmail.com';
    $_POST['no_hp'] = '081234567451';
    $_POST['address'] = 'jl.dulu ga sih';
    $_POST['username'] = 'budiajah';
    $_POST['password'] = 'qwerty123';

    $this->userController->postRegister();

    $this->expectOutputRegex("[DAFTAR]");
    $this->expectOutputRegex("[User Sudah Terdaftar]");
  }
}
