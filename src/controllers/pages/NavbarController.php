<?php

namespace App\src\controllers\pages;

use App\src\database\tables\UserModel;
use App\src\views\NavbarViews\Navbar;

class NavbarController
{
    private UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function defaultMethod(): void
    {
        $user = $this->userModel->findBylogin("admin", "1234");
        $all = $this->userModel->all();
        (new Navbar())->show($user, $all);
    }
}
