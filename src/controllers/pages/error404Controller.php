<?php

namespace App\src\controllers\pages;

use App\src\views\Error404Views\Error404;

class error404Controller
{
    public function defaultMethod(): void
    {
        (new Error404())->show();
    }
}