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
        $content = $this->pageControlleur->genererContenu();
        $this->pageControlleur->genererIntro();
        if ($this->pageControlleur->getName() == 'Homepage') {
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
        }
        else {
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
        echo '</main>';
        (new Layout($page[0]['pagetitle'], ob_get_clean()))->show();

    }
}