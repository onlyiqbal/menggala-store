<?php

namespace Iqbal\MenggalaStore\Config;

use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase
{
  public function testGetConnection()
  {
    $connection = Database::getConnection();
    $this->assertNotNull($connection);
  }

  public function testGetConnectionSingleton()
  {
    $connection1 = Database::getConnection();
    $connection2 = Database::getConnection();
    $this->assertSame($connection1, $connection2);
  }
}
