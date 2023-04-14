<?php

namespace Iqbal\MenggalaStore\App;

class View
{

    public static function render(string $view, $model)
    {
        require __DIR__ . '/../View/' . $view . '.php';
    }
    public static function load(string $template, $view, $model =  null)
    {
        require __DIR__ . '/../View/' . $template . '.php';
    }
}
