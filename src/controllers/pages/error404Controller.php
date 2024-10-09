<?php

namespace App\src\controllers\pages;

class error404Controller
{
    public function defaultMethod(): void
    {
        (new \App\src\views\Error404Views\Error404())->show();
    }
}