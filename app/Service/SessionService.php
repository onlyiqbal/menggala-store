<?php

namespace Iqbal\MenggalaStore\Service;

use Iqbal\MenggalaStore\Repository\SessionRepository;

class SessionService
{
  public SessionRepository $sessionRepository;
  public static string $SECRET_KEY = "la7436gferygu4t82736dhg842r8h83r";
  public static string $COOKIE_NAME = "X-USER-SESSION";

  public function __construct(SessionRepository $sessionRepository)
  {
    $this->sessionRepository = $sessionRepository;
  }

  
}
