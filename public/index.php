<?php

use Iqbal\MenggalaStore\App\Router;
use Iqbal\MenggalaStore\Controller\HomeController;
use Iqbal\MenggalaStore\Controller\UserController;

require_once __DIR__ . '/../vendor/autoload.php';

Router::add('GET', '/products/([0-9a-zA-Z]*)/categories/([0-9a-zA-Z]*)', ProductController::class, 'categories');

Router::add('GET', '/register', UserController::class, 'register');
Router::add('POST', '/register', UserController::class, 'postRegister');
Router::add('GET', '/world', HomeController::class, 'world', [AuthMiddleware::class]);

Router::run();
