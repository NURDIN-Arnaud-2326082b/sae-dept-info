<?php

namespace App\src\controllers;
use App\src\database\DatabaseConnection;
use App\src\models\pageModel;
use App\src\views\Page;

class PageControlleur
{
    private string $name;
    private pageModel $pageModel;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->pageModel = new pageModel(DatabaseConnection::getInstance());
    }

    public function defaultMethod(): void
    {
        (new Page($this->name))->show();
    }

    public function genererTitre()
    {
        return $this->pageModel->genererTitre($this->name);
    }

    public function genererContenu()
    {
        return $this->pageModel->genererContenu($this->name);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function genererIntro()
    {
        $content = $this->genererContenu();
        echo '<link rel="stylesheet" href="/assets/styles/'.$this->name.'.css"><main>';
        foreach ($content as $ct) {
            switch ($ct['type']) {
                case 'banderolle':
                    echo '<div class="marquee">';
                    echo '<h2>' . $ct['title'] . '</h2>';
                    echo '</div>';
                    break;
                case 'intro':
                    echo ' <section class="hero-section"><div class="hero-content">';
                    echo '<h1>' . $ct['title'] . '</h1>';
                    echo '<p>' . $ct['content'] . '</p>';
                    echo '<a href="#content" class="btn-scroll">En savoir plus</a>';
                    echo '</section>';
                    break;
                default:
                        break;
            }
}
    }
}