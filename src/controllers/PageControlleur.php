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
        $connexionController = new ConnexionController();
        (new Page($this->name, $connexionController))->show();
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
        echo '<link rel="stylesheet" href="/assets/styles/'.$this->getName().'.css"><main>';
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

    public function genererArticles()
    {
        $content = $this->genererContenu();
        if ($this->getName() == 'Homepage') {
            echo '  <div class="articles-grid">';
            foreach ($content as $ct) {
                if ($ct['type'] == 'homepage') {
                    echo '<div class="article-preview"><div class="article-content">';
                    echo '<h3>' . $ct['title'] . '</h3>';
                    echo '<p>' . $ct['content'] . '</p>';
                    echo '<a href="' . $ct['link'] . '" class="read-more">En savoir plus</a>';
                    echo '</div>' . '<img src="/assets/images/formation.png" alt="Illustration de l\'éco-ambassadeur" class="article-image"></div>';
                }
            }
            echo '</div>';
        } else {
            echo '<section id="content" class="department-content">';
            $cpt = 1;
            foreach ($content as $ct) {
                switch ($ct['type']) {
                    case 'texte':
                        echo '<div class="intro">';
                        echo '<h2>' . $ct['title'] . '</h2>';
                        echo '<p>' . $ct['content'] . '</p>';
                        echo '</div>';
                        break;
                    case 'list' . $cpt:
                        $cpt2 = 0;
                        echo '<div class="features-grid">';
                        foreach ($content as $ct2) {
                            if ($ct2['type'] == 'list' . $cpt) {
                                echo '<div class="feature">';
                                echo '<img src="/assets/images/img.png" alt="Innovation">';
                                echo '<h3>' . $ct2['title'] . '</h3>';
                                echo '<p>' . $ct2['content'] . '</p>';
                                echo '</div>';
                                $cpt2++;
                            }
                        }
                        for ($i = 0; $i < $cpt2; $i++) {
                            array_shift($content);
                        }
                        echo '</div>';
                        $cpt++;
                        break;
                    case 'titre':
                        echo '<h2>' . $ct['title'] . '</h2>';
                        break;
                    default:
                        break;
                }
            }
        }
    }
}