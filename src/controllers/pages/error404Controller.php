<?php

namespace App\src\controllers\pages;

class error404Controller
{
    public function defaultMethod(): void
    {
        (new \App\src\views\Error404())->show();
    }
}