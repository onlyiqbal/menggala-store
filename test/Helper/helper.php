<?php

namespace Iqbal\MenggalaStore\App {
  function header(string $value)
  {
    echo $value;
  }
}

namespace Iqbal\MenggalaStore\Service {
  function setcookie(string $name, string $value)
  {
    echo "$name: $value";
  }
}
