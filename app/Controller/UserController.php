<?php

namespace Iqbal\MenggalaStore\Controller;

use Iqbal\MenggalaStore\App\View;
use Iqbal\MenggalaStore\Config\Database;
use Iqbal\MenggalaStore\Exception\ValidationException;
use Iqbal\MenggalaStore\Model\UserRegisterRequest;
use Iqbal\MenggalaStore\Repository\SessionRepository;
use Iqbal\MenggalaStore\Repository\UserRepository;
use Iqbal\MenggalaStore\Service\SessionService;
use Iqbal\MenggalaStore\Service\UserService;

class UserController
{
  private UserRepository $userRepository;
  private UserService $userService;
  private SessionRepository $sessionRepository;
  private SessionService $sessionService;

  public function __construct()
  {
    $connection = Database::getConnection();
    $this->userRepository = new UserRepository($connection);
    $this->userService = new UserService($this->userRepository);

    $this->sessionRepository = new SessionRepository($connection);
    $this->sessionService = new SessionService($this->sessionRepository);
  }

  public function register()
  {
    View::render("User/register", [
      'title' => 'Register Akun'
    ]);
  }

  public function postRegister()
  {
    $request = new UserRegisterRequest();
    $request->name = $_POST['name'];
    $request->email = $_POST['email'];
    $request->no_hp = $_POST['no_hp'];
    $request->address = $_POST['address'];
    $request->username = $_POST['username'];
    $request->password = $_POST['password'];

    try {
      $this->userService->register($request);
      View::redirect("/login");
    } catch (ValidationException $exception) {
      View::render("User/register", [
        'title' => 'Register Akun',
        'error' => $exception->getMessage(),
      ]);
    }
  }
}
