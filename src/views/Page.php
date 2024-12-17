<?php

namespace App\src\views;

use App\src\controllers\PageControlleur;
use App\src\views\LayoutViews\Layout;

class Page
{
    private pageControlleur $pageControlleur;
    
    public function __construct(string $name)
    {
        $this->pageControlleur = new PageControlleur($name);
    }
    public function show(): void
    {
        ob_start();
        $page = $this->pageControlleur->genererTitre();
        $this->pageControlleur->genererIntro();
        $this->pageControlleur->genererArticles();
        (new Layout($page[0]['pagetitle'], ob_get_clean()))->show();

    }
}