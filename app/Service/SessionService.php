<?php

namespace Iqbal\MenggalaStore\Service;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Iqbal\MenggalaStore\Domain\Session;
use Iqbal\MenggalaStore\Exception\ValidationException;
use Iqbal\MenggalaStore\Repository\SessionRepository;

class SessionService
{
  public SessionRepository $sessionRepository;
  public static string $SECRET_KEY = "la7436gferygu4t82736dhg842r8h83r";
  public static string $COOKIE_NAME = "X-MENGGALA-SESSION";

  public function __construct(SessionRepository $sessionRepository)
  {
    $this->sessionRepository = $sessionRepository;
  }

  public function create(string $user_id): Session
  {
    $session = new Session();
    $session->session_id = uniqid();
    $session->user_id = $user_id;

    $this->sessionRepository->save($session);

    $payload = [
      'session_id' => $session->session_id,
      'username' => $session->user_id,
      'role' => 'user'
    ];

    $jwt = JWT::encode($payload, self::$SECRET_KEY, 'HS256');

    setcookie(self::$COOKIE_NAME, $jwt, time() + (60 * 60 * 24 * 30), '/');

    return $session;
  }

  public function destroy(string $session_id)
  {
    $this->sessionRepository->deleteById($session_id);
    setcookie(self::$COOKIE_NAME, "", 1, "/");
  }

  public function current(): ?Session
  {
    if (isset(self::$COOKIE_NAME)) {
      $jwt = $_COOKIE[self::$COOKIE_NAME];
      try {
        $payload = JWT::decode($jwt, new Key(self::$SECRET_KEY, 'HS256'));
        $session = new Session();
        $session->session_id = $payload->session_id;
        $session->user_id = $payload->user_id;

        return $this->sessionRepository->findById($session->session_id);
      } catch (ValidationException $exception) {
        throw new ValidationException('Anda belum login');
      }
    }
  }
}
