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

    public function genererIntro(): void
    {
        $content = $this->genererContenu();
        echo '<link rel="stylesheet" href="/assets/styles/'.$this->getName().'.css"><main>';
        if($_SESSION['admin']){
            foreach ($content as $ct) {
                switch ($ct['type']) {
                    case 'banderolle':
                        echo '<div class="marquee"><form action="/updateArticle" method="post">';
                        echo '<input type="hidden" name="id" value="'.$ct['id_article'].'" /><input type="text" value="'.$ct['title'].'" style="font-size: 2.5rem; font-weight: bold; text-align: center; width: 100%; border: none; background: transparent;" name="titre"/>';
                        echo '<button type="submit">Enregistrer les modifications</button></form></div>';
                        break;
                    case 'intro':
                        echo ' <section class="hero-section"><div class="hero-content"><form action="/updateArticle" method="post">';
                        echo '<input type="hidden" name="id" value="'.$ct['id_article'].'" /><input type="text" value="'.$ct['title'].'" style="font-size: 2.5rem; font-weight: bold; text-align: center; width: 100%; border: none; background: transparent;" name="titre"/>';
                        echo '<textarea rows="3" cols="50" style="font-size: 1.25rem; width: 100%; text-align: center; border: none; background: transparent;" name="contenu">'. $ct['content'] .'</textarea>';
                        echo '<a href="#content" class="btn-scroll">En savoir plus</a>';
                        echo '<button type="submit">Enregistrer les modifications</button></form></section>';
                        break;
                    default:
                        break;
                }
            }
        }
        else {
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

    public function genererArticles(): void
    {
        $content = $this->genererContenu();
        if ($_SESSION['admin']) {
            if ($this->getName() == 'Homepage') {
                echo '  <div class="articles-grid">';
                foreach ($content as $ct) {
                    if ($ct['type'] == 'homepage') {
                        echo '<div class="article-preview"><div class="article-content"><form action="/updateArticle" method="post">';
                        echo '<input type="hidden" name="id" value="'.$ct['id_article'].'"/><input type="text" value="'.$ct['title'].'" style="font-size: 2.5rem; font-weight: bold; text-align: center; width: 100%; border: none; background: transparent;" name="titre"/>';
                        echo '<textarea rows="3" cols="50" style="font-size: 1.25rem; width: 100%; text-align: center; border: none; background: transparent;" name="contenu">'. $ct['content'] .'</textarea>';
                        echo '<a href="' . $ct['link'] . '" class="read-more">En savoir plus</a>';
                        echo ' <button type="submit">Enregistrer les modifications</button></form></div>' . '<img src="/assets/images/formation.png" alt="Illustration de l\'éco-ambassadeur" class="article-image"></div>';
                    }
                }
                echo '</div>';
            } elseif ($this->getName() == 'menu') {
                echo '<div class="panel-container">';
                foreach ($content as $ct) {
                    if ($ct['type'] == 'menu') {
                        echo '<div class="panel" onclick="window.location.href=\'' . $ct['link'] . '\';"><form action="/updateArticle" method="post"><input type="hidden" name="id" value="'.$ct['id_article'].'"/>';
                        echo '<textarea rows="3" cols="50" style="font-size: 1.25rem; width: 100%; text-align: center; border: none; background: transparent;" name="contenu">'. $ct['title'] .'</textarea>';
                        echo '<button type="submit">Enregistrer les modifications</button></form></div>';
                    }
                }
                echo '</div>';
            }
            echo '<section id="content" class="department-content">';
            $cpt = 1;
            foreach ($content as $ct) {
                switch ($ct['type']) {
                    case 'texte':
                        echo '<div class="intro"><form action="/updateArticle" method="post">';
                        echo '<input type="hidden" name="id" value="'.$ct['id_article'].'" /><input type="text" value="'.$ct['title'].'" style="font-size: 2.5rem; font-weight: bold; text-align: center; width: 100%; border: none; background: transparent;" name="titre"/>';
                        echo '<textarea rows="3" cols="50" style="font-size: 1.25rem; width: 100%; text-align: center; border: none; background: transparent;" name="contenu">'. $ct['content'] .'</textarea>';
                        echo '<button type="submit">Enregistrer les modifications</button></form></div>';
                        break;
                    case 'list' . $cpt:
                        $cpt2 = 0;
                        echo '<div class="features-grid">';
                        foreach ($content as $ct2) {
                            if ($ct2['type'] == 'list' . $cpt) {
                                echo '<div class="feature"><form action="/updateArticle" method="post">';
                                echo '<img src="/assets/images/img.png" alt="Innovation">';
                                echo '<input type="hidden" name="id" value="'.$ct['id_article'].'"/><input type="text" value="'.$ct['title'].'" style="font-size: 2.5rem; font-weight: bold; text-align: center; width: 100%; border: none; background: transparent;" name="titre"/>';
                                echo '<textarea rows="3" cols="50" style="font-size: 1.25rem; width: 100%; text-align: center; border: none; background: transparent;" name="contenu">'. $ct['content'] .'</textarea>';
                                echo '<button type="submit">Enregistrer les modifications</button></form></div>';
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
                        echo '<form action="/updateArticle" method="post"><input type="hidden" name="id" value="'.$ct['id_article'].'"/><input type="text" value="'.$ct['title'].'" style="font-size: 2.5rem; font-weight: bold; text-align: center; width: 100%; border: none; background: transparent;" name="titre"/><button type="submit">Enregistrer les modifications</button></form>';
                        break;
                    case 'lien':
                        echo '<div><form action="/updateArticle" method="post"><input type="hidden" name="id" value="'.$ct['id_article'].'"/><textarea rows="3" cols="50" style="font-size: 1.25rem; width: 100%; text-align: center; border: none; background: transparent;" name="lien">'. $ct['link'] .'</textarea><textarea rows="3" cols="50" style="font-size: 1.25rem; width: 100%; text-align: center; border: none; background: transparent;" name="contenu">'. $ct['content'] .'</textarea><button type="submit">Enregistrer les modifications</button></form></div>';
                        break;
                    default:
                        break;
                }
            }
        }
        else {
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
            } elseif ($this->getName() == 'menu') {
                echo '<div class="panel-container">';
                foreach ($content as $ct) {
                    if ($ct['type'] == 'menu') {
                        echo '<div class="panel" onclick="window.location.href=\'' . $ct['link'] . '\';">';
                        echo '<h2>' . $ct['title'] . '</h2>';
                        echo '</div>';
                    }
                }
                echo '</div>';
            }
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
                    case 'lien':
                        echo '<div><a href="' . $ct['link'] . '" >'.$ct['content'].'</a></div>';
                        break;
                    default:
                        break;
                }
            }
        }
    }

    /**
     * @throws \Exception
     */
    public function updateArticleAction(): void
    {
        $id = $_POST['id'];
        $titre = $_POST['titre'];
        $contenu = $_POST['contenu'];
        $lien = $_POST['lien'];
        $model = new pageModel(DatabaseConnection::getInstance());
        $model->updateArticleAction($id,$titre, $contenu,$lien);
    }
}