<?php

function getDatabaseConfig(): array
{
  return [
    'database' => [
      'test' => [
        'url' => 'mysql:host=localhost:3306;dbname=db_menggala_store_test',
        'username' => 'root',
        'password' => ''
      ],
      'prod' => [
        'url' => 'mysql:host=localhost:3306;dbname=db_menggala_store',
        'username' => 'root',
        'password' => ''
      ]
    ]
  ];
}
