<?php

namespace Iqbal\MenggalaStore\Controller;

use Iqbal\MenggalaStore\App\View;

class HomeController
{
    function index(): void
    {
        View::load('Home/index', '/test');
    }
}
