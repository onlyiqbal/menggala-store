<?php

namespace Iqbal\MenggalaStore\Service;

use Exception;
use Iqbal\MenggalaStore\Config\Database;
use Iqbal\MenggalaStore\Domain\User;
use Iqbal\MenggalaStore\Exception\ValidationException;
use Iqbal\MenggalaStore\Model\UserLoginRequest;
use Iqbal\MenggalaStore\Model\UserLoginResponse;
use Iqbal\MenggalaStore\Model\UserRegisterRequest;
use Iqbal\MenggalaStore\Model\UserRegisterResponse;
use Iqbal\MenggalaStore\Repository\UserRepository;

class UserService
{
  private UserRepository $userRepository;

  public function __construct(UserRepository $userRepository)
  {
    $this->userRepository = $userRepository;
  }


  public function register(UserRegisterRequest $request): UserRegisterResponse
  {
    $this->userRegisterValidation($request);

    $user = $this->userRepository->findByNoHp($request->no_hp);
    if ($user !== null) {
      throw new ValidationException("User Sudah Terdaftar");
    }

    try {
      Database::beginTransaction();
      $user = new User();
      $user->name = $request->name;
      $user->email = $request->email;
      $user->no_hp = $request->no_hp;
      $user->address = $request->address;
      $user->username = $request->username;
      $user->password = password_hash($request->password, PASSWORD_BCRYPT);

      $this->userRepository->save($user);

      $response = new UserRegisterResponse();
      $response->user = $user;

      Database::commitTransaction();

      return $response;
    } catch (Exception $exception) {
      Database::rollbackTransaction();
      throw $exception;
    }
  }

  private function userRegisterValidation(UserRegisterRequest $request)
  {
    if (($request->name == null || trim($request->name) == "") || ($request->email == null || trim($request->email) == "") || ($request->no_hp == null || trim($request->no_hp) == "") || ($request->address == null || trim($request->address) == "") || ($request->username == null || trim($request->username) == "") || ($request->password == null || trim($request->password) == "")) {
      throw new ValidationException("Form Register Tidak Boleh Kosong");
    }
  }

  public function login(UserLoginRequest $request): UserLoginResponse
  {
    $this->userLoginValidation($request);

    $user = $this->userRepository->findByUsername($request->username);

    if ($user == null) {
      throw new ValidationException("username atau password salah");
    }

    if (password_verify($request->password, $user->password)) {
      $response = new UserLoginResponse();
      $response->user = $user;

      return $response;
    }
  }

  private function userLoginValidation(UserLoginRequest $request)
  {
    if (($request->username == null || "") || ($request->password == null || "")) {
      throw new ValidationException("Form Login Tidak Boleh Kosong");
    }
  }
}
