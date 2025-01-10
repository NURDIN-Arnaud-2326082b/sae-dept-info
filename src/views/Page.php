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

    public function genererIntro(): void
    {
        $content = $this->pageControlleur->genererContenu();
        echo '<link rel="stylesheet" href="/assets/styles/page.css"><main>';
        if (isset($_SESSION['admin']) && $_SESSION['admin']) {
            foreach ($content as $ct) {
                switch ($ct['type']) {
                    case 'banderolle':
                        echo '<div class="marquee"><form action="/PageControlleur/updateArticle" method="post"><input type="hidden" name="name" value="'.$this->pageControlleur->getName().'"/>';
                        echo '<input type="hidden" name="id" value="'.$ct['id_article'].'" /><input type="text" value="'.$ct['title'].'" style="font-size: 2.5rem; font-weight: bold; text-align: center; width: 100%; border: none; background: transparent;" name="titre"/>';
                        echo '<button type="submit">Enregistrer les modifications</button></form>';
                        echo "<form action='/PageControlleur/deleteArticle' method='POST'><input type='hidden' name='action' value='delete'><input type='hidden' name='type' value='".$ct['type']. "'><input type='hidden' name='name' value='".$this->pageControlleur->getName()."'/><button type='submit' name='delete' value='". $ct['id_article'] . "'>Supprimer l'article'</button></form></div>";
                        break;
                    case 'intro':
                        echo ' <section class="hero-section"><div class="hero-content">';
                        echo '<form action="/PageControlleur/updateArticle" method="post"><input type="hidden" name="name" value="'.$this->pageControlleur->getName().'"/>';
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
                        echo '<img src="/PageControlleur/getImage?id='.$ct['id_article'].'" alt="'.$ct['title'].'">';
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
        $content = $this->pageControlleur->genererContenu();
        if (isset($_SESSION['admin'])) {
            if ($this->pageControlleur->getName() == 'Homepage') {
                echo '  <div class="articles-grid">';
                foreach ($content as $ct) {
                    if ($ct['type'] == 'homepage') {
                        echo '<div class="article-preview"><div class="article-content">';
                        echo '<img src="/PageControlleur/getImage?id='.$ct['id_article'].'" alt="'.$ct['title'].'">';
                        echo '<form action="/PageControlleur/updateImage" method="post" enctype="multipart/form-data">';
                        echo '<input type="hidden" name="id" value="'.$ct['id_article'].'">';
                        echo '<label for="file-'.$ct['id_article'].'" class="dropzone">Glissez & déposez une image ou cliquez ici</label>';
                        echo '<input type="file" id="file-'.$ct['id_article'].'" name="image" accept="image/*" onchange="this.form.submit()" style="display: none;">';
                        echo '<input type="hidden" name="name" value="'.$this->pageControlleur->getName().'"/>';
                        echo '</form>';
                        echo '<form action="/PageControlleur/updateArticle" method="post"><input type="hidden" name="name" value="'.$this->pageControlleur->getName().'"/>';
                        echo '<input type="hidden" name="id" value="'.$ct['id_article'].'"/><input type="text" value="'.$ct['title'].'" style="font-size: 2.5rem; font-weight: bold; text-align: center; width: 100%; border: none; background: transparent;" name="titre"/>';
                        echo '<textarea rows="3" cols="50" style="font-size: 1.25rem; width: 100%; text-align: center; border: none; background: transparent;" name="contenu">'. $ct['content'] .'</textarea>';
                        echo '<a href="' . $ct['link'] . '" class="read-more">En savoir plus</a>';
                        echo "<button type='submit'>Enregistrer les modifications</button></form><form action='/PageControlleur/deleteArticle' method='POST'><input type='hidden' name='action' value='delete'><input type='hidden' name='type' value='".$ct['type']. "'><input type='hidden' name='name' value='".$this->pageControlleur->getName()."'/><button type='submit' name='delete' value='". $ct['id_article'] . "'>Supprimer l'article</button></form></div>";
                        echo '</div>';
                    }
                }
                echo "<form action='/PageControlleur/ajouterArticle' method='post'><input type='hidden' name='name' value='".$this->pageControlleur->getName()."'/><input type='hidden' name='type' value='homepage'/><button type='submit' name='add'>Ajouter un article</button></form>";
                echo '</div>';
            } elseif ($this->pageControlleur->getName()== 'menu') {
                echo '<div class="panel-container">';
                foreach ($content as $ct) {
                    if ($ct['type'] == 'menu') {
                        echo '<div class="feature"><form action="/PageControlleur/updateArticle" method="post"><input type="hidden" name="name" value="'.$this->pageControlleur->getName().'"/><input type="hidden" name="id" value="'.$ct['id_article'].'"/>';
                        echo '<textarea rows="3" cols="50" style="font-size: 1.25rem; width: 100%; text-align: center; border: none; background: transparent;" name="titre">'. $ct['title'] .'</textarea>';
                        echo '<button type="submit">Enregistrer les modifications</button></form>';
                        echo "<form action='/PageControlleur/deleteArticle' method='POST'><input type='hidden' name='action' value='delete'><input type='hidden' name='type' value='".$ct['type']. "'><input type='hidden' name='name' value='".$this->pageControlleur->getName()."'/><button type='submit' name='delete' value='". $ct['id_article'] . "'>Supprimer l'article</button></form>";
                        echo '<a href="' . $ct['link'] . '" class="read-more">Accéder à la page</a>';
                        echo '</div>';
                    }
                }
                echo "<form action='/PageControlleur/ajouterArticle' method='post'><input type='hidden' name='name' value='".$this->pageControlleur->getName()."'/><input type='hidden' name='type' value='menu'/><button type='submit' name='add'>Ajouter un article</button></form>";
                echo '</div>';
            }

            if ($content[0] != null) {
                echo '<section id="content" class="department-content">';
            }
            $cpt = 1;
            $cptlink = 1;
            foreach ($content as $ct) {
                switch ($ct['type']) {
                    case 'texte':
                        echo '<div class="intro"><form action="/PageControlleur/updateArticle" method="post"><input type="hidden" name="name" value="'.$this->pageControlleur->getName().'"/>';
                        echo '<input type="hidden" name="id" value="'.$ct['id_article'].'" /><input type="text" value="'.$ct['title'].'" style="font-size: 2.5rem; font-weight: bold; text-align: center; width: 100%; border: none; background: transparent;" name="titre"/>';
                        echo '<textarea rows="3" cols="50" style="font-size: 1.25rem; width: 100%; text-align: center; border: none; background: transparent;" name="contenu">'. $ct['content'] .'</textarea>';
                        echo '<button type="submit">Enregistrer les modifications</button></form>';
                        echo "<form action='/PageControlleur/deleteArticle' method='POST'><input type='hidden' name='action' value='delete'><input type='hidden' name='type' value='".$ct['type']. "'><input type='hidden' name='name' value='".$this->pageControlleur->getName()."'/><button type='submit' name='delete' value='". $ct['id_article'] . "'>Supprimer l'article'</button></form>";
                        echo '</div>';
                        break;
                    case 'list' . $cpt:
                        $cpt2 = 0;
                        echo '<div class="features-grid">';
                        foreach ($content as $ct2) {
                            if ($ct2['type'] == 'list' . $cpt) {
                                echo '<div class="feature">';
                                echo '<img src="/PageControlleur/getImage?id='.$ct2['id_article'].'" alt="'.$ct2['title'].'">';
                                echo '<form action="/PageControlleur/updateImage" method="post" enctype="multipart/form-data">';
                                echo '<input type="hidden" name="id" value="'.$ct2['id_article'].'">';
                                echo '<label for="file-'.$ct2['id_article'].'" class="dropzone">Glissez & déposez une image ou cliquez ici</label>';
                                echo '<input type="file" id="file-'.$ct2['id_article'].'" name="image" accept="image/*" onchange="this.form.submit()" style="display: none;">';
                                echo '<input type="hidden" name="name" value="'.$this->pageControlleur->getName().'"/>';
                                echo '</form>';
                                echo '<form action="/PageControlleur/updateArticle" method="post"><input type="hidden" name="name" value="'.$this->pageControlleur->getName().'"/>';
                                echo '<input type="hidden" name="id" value="'.$ct2['id_article'].'"/><input type="text" value="'.$ct2['title'].'" style="font-size: 2.5rem; font-weight: bold; text-align: center; width: 100%; border: none; background: transparent;" name="titre"/>';
                                var_dump($ct2['id_article']);
                                echo '<textarea rows="3" cols="50" style="font-size: 1.25rem; width: 100%; text-align: center; border: none; background: transparent;" name="contenu">'. $ct2['content'] .'</textarea>';
                                echo '<button type="submit">Enregistrer les modifications</button></form>';
                                echo "<form action='/PageControlleur/deleteArticle' method='POST'><input type='hidden' name='action' value='delete'><input type='hidden' name='type' value='".$ct['type']. "'><input type='hidden' name='name' value='".$this->pageControlleur->getName()."'/><button type='submit' name='delete' value='". $ct2['id_article'] . "'>Supprimer l'article'</button></form>";
                                echo '</div>';
                                $cpt2++;
                            }
                        }
                        for ($i = 0; $i < $cpt2; $i++) {
                            array_shift($content);
                        }
                        $type = $ct['type'];
                        echo '<form action="/PageControlleur/ajouterArticle" method="post"><input type="hidden" name="name" value="'.$this->pageControlleur->getName().'"/><input type="hidden" name="type" value="'.$type.'"/><button type="submit" name="add">Ajouter un article</button></form>';
                        echo '</div>';
                        $cpt++;
                        break;
                    case 'titre':
                        echo '<form action="/PageControlleur/updateArticle" method="post"><input type="hidden" name="name" value="'.$this->pageControlleur->getName().'"/><input type="hidden" name="id" value="'.$ct['id_article'].'"/><input type="text" value="'.$ct['title'].'" style="font-size: 2.5rem; font-weight: bold; text-align: center; width: 100%; border: none; background: transparent;" name="titre"/><button type="submit">Enregistrer les modifications</button></form>';
                        echo "<form action='/PageControlleur/deleteArticle' method='POST'><input type='hidden' name='action' value='delete'><input type='hidden' name='type' value='".$ct['type']. "'><input type='hidden' name='name' value='".$this->pageControlleur->getName()."'/><button type='submit' name='delete' value='". $ct['id_article'] . "'>Supprimer l'article'</button></form>";
                        break;
                    case 'lien':
                        echo '<div><form action="/PageControlleur/updateArticle" method="post"><input type="hidden" name="name" value="'.$this->pageControlleur->getName().'"/><input type="hidden" name="id" value="'.$ct['id_article'].'"/><textarea rows="3" cols="50" style="font-size: 1.25rem; width: 100%; text-align: center; border: none; background: transparent;" name="lien">'. $ct['link'] .'</textarea><textarea rows="3" cols="50" style="font-size: 1.25rem; width: 100%; text-align: center; border: none; background: transparent;" name="contenu">'. $ct['content'] .'</textarea><button type="submit">Enregistrer les modifications</button></form>';
                        echo "<form action='/PageControlleur/deleteArticle' method='POST'><input type='hidden' name='action' value='delete'><input type='hidden' name='type' value='".$ct['type']. "'><input type='hidden' name='name' value='".$this->pageControlleur->getName()."'/><button type='submit' name='delete' value='". $ct['id_article'] . "'>Supprimer l'article'</button></form>";
                        echo '</div>';
                        break;
                    case 'paragraphe':
                        echo '<div><form action="/PageControlleur/updateArticle" method="post"><input type="hidden" name="name" value="'.$this->pageControlleur->getName().'"/><input type="hidden" name="id" value="'.$ct['id_article'].'"/><textarea rows="3" cols="50" style="font-size: 1.25rem; width: 100%; text-align: center; border: none; background: transparent;" name="contenu">'. $ct['content'] .'</textarea><button type="submit">Enregistrer les modifications</button></form>';
                        echo "<form action='/PageControlleur/deleteArticle' method='POST'><input type='hidden' name='action' value='delete'><input type='hidden' name='type' value='".$ct['type']. "'><input type='hidden' name='name' value='".$this->pageControlleur->getName()."'/><button type='submit' name='delete' value='". $ct['id_article'] . "'>Supprimer l'article'</button></form>";
                        echo '</div>';
                        break;
                    case 'img':
                        echo '<div>';
                        echo '<img src="/PageControlleur/getImage?id='.$ct['id_article'].'" alt="'.$ct['title'].'">';
                        echo '<form action="/PageControlleur/updateImage" method="post" enctype="multipart/form-data">';
                        echo '<input type="hidden" name="id" value="'.$ct['id_article'].'">';
                        echo '<label for="file-'.$ct['id_article'].'" class="dropzone">Glissez & déposez une image ou cliquez ici</label>';
                        echo '<input type="file" id="file-'.$ct['id_article'].'" name="image" accept="image/*" onchange="this.form.submit()" style="display: none;">';
                        echo '<input type="hidden" name="name" value="'.$this->pageControlleur->getName().'"/>';
                        echo '</form>';
                        echo "<form action='/PageControlleur/deleteArticle' method='POST'><input type='hidden' name='type' value='".$ct['type']. "'><input type='hidden' name='action' value='delete'><input type='hidden' name='name' value='".$this->pageControlleur->getName()."'/><button type='submit' name='delete' value='". $ct['id_article'] . "'>Supprimer l'article'</button></form>";
                        echo '</div>';
                        break;
                    case 'lstlinked' . $cptlink:
                        $cpt2 = 0;
                        echo '<div class="features-grid">';
                        foreach ($content as $ct2) {
                            if ($ct2['type'] == 'lstlinked' . $cptlink) {
                                echo '<div class="feature">';
                                echo '<img src="/PageControlleur/getImage?id='.$ct2['id_article'].'" alt="'.$ct2['title'].'">';
                                echo '<form action="/PageControlleur/updateImage" method="post" enctype="multipart/form-data">';
                                echo '<input type="hidden" name="id" value="'.$ct2['id_article'].'">';
                                echo '<label for="file-'.$ct2['id_article'].'" class="dropzone">Glissez & déposez une image ou cliquez ici</label>';
                                echo '<input type="file" id="file-'.$ct2['id_article'].'" name="image" accept="image/*" onchange="this.form.submit()" style="display: none;">';
                                echo '<input type="hidden" name="name" value="'.$this->pageControlleur->getName().'"/>';
                                echo '</form>';
                                echo '<form action="/PageControlleur/updateArticle" method="post"><input type="hidden" name="name" value="'.$this->pageControlleur->getName().'"/>';
                                echo '<input type="hidden" name="id" value="'.$ct2['id_article'].'"/><input type="text" value="'.$ct2['title'].'" style="font-size: 2.5rem; font-weight: bold; text-align: center; width: 100%; border: none; background: transparent;" name="titre"/>';
                                echo '<textarea rows="3" cols="50" style="font-size: 1.25rem; width: 100%; text-align: center; border: none; background: transparent;" name="contenu">'. $ct2['content'] .'</textarea><textarea rows="3" cols="50" style="font-size: 1.25rem; width: 100%; text-align: center; border: none; background: transparent;" name="lien">'. $ct['link'] .'</textarea>';
                                echo '<button type="submit">Enregistrer les modifications</button></form>';
                                echo "<form action='/PageControlleur/deleteArticle' method='POST'><input type='hidden' name='action' value='delete'><input type='hidden' name='type' value='".$ct['type']. "'><input type='hidden' name='name' value='".$this->pageControlleur->getName()."'/><button type='submit' name='delete' value='". $ct2['id_article'] . "'>Supprimer l'article'</button></form>";
                                echo '</div>';
                                $cpt2++;
                            }
                        }
                        for ($i = 0; $i < $cpt2; $i++) {
                            array_shift($content);
                        }
                        $type = $ct['type'];
                        echo '<form action="/PageControlleur/ajouterArticle" method="post"><input type="hidden" name="name" value="'.$this->pageControlleur->getName().'"/><input type="hidden" name="type" value="'.$type.'"/><button type="submit" name="add">Ajouter un article</button></form>';
                        echo '</div>';
                        $cptlink++;
                        break;
                    case 'pdf':
                        echo '<div>';
                        echo '<a href="/PageControlleur/getPdf?id='.$ct['id_article'].'" download="fichier.pdf">Télécharger le PDF</a>';
                        echo '<form action="/PageControlleur/updatePdf" method="post" enctype="multipart/form-data">';
                        echo '<input type="hidden" name="id" value="'.$ct['id_article'].'">';
                        echo '<label for="file-'.$ct['id_article'].'" class="dropzone">Glissez & déposez un fichier PDF ou cliquez ici</label>';
                        echo '<input type="file" id="file-'.$ct['id_article'].'" name="file" accept="file/pdf" onchange="this.form.submit()" style="display: none;">';
                        echo '<input type="hidden" name="name" value="'.$this->pageControlleur->getName().'"/>';
                        echo '</form>';
                        echo "<form action='/PageControlleur/deleteArticle' method='POST'><input type='hidden' name='type' value='".$ct['type']. "'><input type='hidden' name='action' value='delete'><input type='hidden' name='name' value='".$this->pageControlleur->getName()."'/><button type='submit' name='delete' value='". $ct['id_article'] . "'>Supprimer l'article'</button></form>";
                        echo '</div>';
                        break;
                    case 'useraccess':
                        echo '<div class="panel" onclick="window.location.href=\'' . $ct['link'] . '\';">';
                        echo '<h2>' . $ct['title'] . '</h2>';
                        echo '</div>';
                        break ;
                    case 'gestion' :
                        echo '<div class="gestion"><form action="/PageControlleur/ajouterUser" method="post"><input type="hidden" name="page" value="'.$this->pageControlleur->getName().'"/><h2>email</h2><input type="text" value="" style="font-size: 2.5rem; font-weight: bold; text-align: center; width: 100%; border: none; background: transparent;" name="email"/><h2>nom d\'utilisateur</h2><input type="text" value="" style="font-size: 2.5rem; font-weight: bold; text-align: center; width: 100%; border: none; background: transparent;" name="name"/><h2>annee</h2><input type="text" value="" style="font-size: 2.5rem; font-weight: bold; text-align: center; width: 100%; border: none; background: transparent;" name="annee"/><h2>groupe</h2><input type="text" value="" style="font-size: 2.5rem; font-weight: bold; text-align: center; width: 100%; border: none; background: transparent;" name="groupe"/><button type="submit">Enregistrer les modifications</button></form>';
                        echo '</div>';
                        break;
                    default:
                        break;
                }
            }
        }
        else {
            if ($this->pageControlleur->getName() == 'Homepage') {
                echo '  <div class="articles-grid">';
                foreach ($content as $ct) {
                    if ($ct['type'] == 'homepage') {
                        echo '<div class="article-preview">';
                        echo '<img src="/PageControlleur/getImage?id=' . $ct['id_article'] . '" alt="' . htmlspecialchars($ct['title'], ENT_QUOTES) . '" class="article-image">';
                        echo '<div class="article-content">';
                        echo '<h3>' . $ct['title'] . '</h3>';
                        echo '<p>' . $ct['content'] . '</p>';
                        echo '<a href="' . $ct['link'] . '" class="read-more">En savoir plus</a>';
                        echo '</div>';
                        echo '</div>';
                    }
                }
                echo '</div>';
            }
            elseif ($this->pageControlleur->getName() == 'menu') {
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
            $cptlink = 1;
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
                                echo '<img src="/PageControlleur/getImage?id='.$ct2['id_article'].'" alt="'.$ct2['title'].'">';
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
                    case 'paragraphe':
                        echo '<div><p>' . $ct['content'] . '</p></div>';
                        break;
                    case 'image':
                        echo '<div>';
                        echo '<img src="/PageControlleur/getImage?id='.$ct['id_article'].'" alt="'.$ct['title'].'">';
                        echo '</div>';
                        break;
                    case 'lstlinked' . $cptlink :
                        $cpt2 = 0;
                        echo '<div class="features-grid">';
                        foreach ($content as $ct2) {
                            if ($ct2['type'] == 'lstlinked' . $cptlink) {
                                echo '<div class="feature">';
                                echo '<img src="/PageControlleur/getImage?id='.$ct2['id_article'].'" alt="'.$ct2['title'].'">';
                                echo '<h3>' . $ct2['title'] . '</h3>';
                                echo '<p>' . $ct2['content'] . '</p>';
                                echo '<a href="' . $ct['link'] . '"  class="btn-scroll">En savoir plus</a>';
                                echo '</div>';
                                $cpt2++;
                            }
                        }
                        for ($i = 0; $i < $cpt2; $i++) {
                            array_shift($content);
                        }
                        echo '</div>';
                        $cptlink++;
                        break;
                    case 'pdf':
                        echo '<div>';
                        echo '<a href="/PageControlleur/getPdf?id='.$ct['id_article'].'" download="fichier.pdf">Télécharger le PDF</a>';
                        echo '</div>';
                        break;
                    default:
                        break;
                }
            }
        }
    }

    public function genererNewArticle(): void
    {
        $cpts = $this->pageControlleur->recupererListe();
        echo '<section id="content" class="department-content"><div><form action="/PageControlleur/ajouterArticle" method="post"  enctype="multipart/form-data"><input type="hidden" name="name" value="'.$this->name.'"/>';
        echo '<h2>Ajouter un article</h2>';
        echo '<select name="type" id="article-type">';
        echo '<option value="texte">texte avec titre</option>';
        echo "<option value='list". $cpts['cpt']."'>liste d'article</option>";
        echo "<option value='lstlinked".$cpts['cpt2']."'>liste d'article avec lien</option>";
        echo "<option value='banderolle'>banderolle en haut de page</option>";
        echo "<option value='lien'>lien</option>";
        echo "<option value='titre'>titre</option>";
        echo "<option value='paragraphe'>paragraphe</option>";
        echo "<option value='img'>image</option>";
        echo "<option value='pdf'>PDF</option>";
        echo '</select>';
        echo "<button type='submit' name='add'>Ajouter l'article</button></form></div></section>";
    }

    public function show(): void
    {
        ob_start();
        echo '<script src="/assets/js/page.js"></script>';
        $page = $this->pageControlleur->genererTitre();

        $this->genererIntro();
        $this->genererArticles();
        if (isset($_SESSION['admin']) && $_SESSION['admin']) {
            $this->genererNewArticle();
        }
        (new Layout($page[0]['pagetitle'], ob_get_clean()))->show();

    }
}