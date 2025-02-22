<?php

namespace App\src\views\pages;

use App\src\controllers\pages\PageControlleur;
use Exception;

class Show
{
    /**
     * PageControlleur
     * @var PageControlleur controlleur gérant les pages
     */
    private pageControlleur $pageControlleur;

    /**
     * Constructeur de la classe Show
     * @param string $name nom de la page
     */
    public function __construct(string $name)
    {
        $this->pageControlleur = new PageControlleur($name);
    }


    /**
     * Génère l'introduction de la page.
     */
    public function genererIntro(): void
    {
        $content = $this->pageControlleur->genererContenu();
        echo '<link rel="stylesheet" href="/assets/styles/page.css"><main>';
        if (isset($_SESSION['admin']) && $_SESSION['admin']) {
            foreach ($content as $ct) {
                switch ($ct['type']) {
                    case 'banderolle':
                        echo '<div class="marquee"><form action="/PageControlleur/updateArticle" method="post"><input type="hidden" name="name" value="'.$this->pageControlleur->getName().'"/>';
                        echo '<input type="hidden" name="id" value="'.$ct['id_article'].'" /><input type="text" value="'.$ct['title'].'" name="titre"/>';
                        echo '<button class="btn-save" type="submit">Enregistrer les modifications</button></form>';
                        echo "<form action='/PageControlleur/deleteArticle' method='POST'><input type='hidden' name='action' value='delete'><input type='hidden' name='type' value='".$ct['type']. "'><input type='hidden' name='name' value='".$this->pageControlleur->getName()."'/><button class='btn-delete' type='submit' name='delete' value='". $ct['id_article'] . "'>Supprimer l'article</button></form></div>";
                        break;
                    case 'intro':
                        echo ' <section class="hero-section"><div class="hero-content">';
                        echo '<form action="/PageControlleur/updateArticle" method="post"><input type="hidden" name="name" value="'.$this->pageControlleur->getName().'"/>';
                        echo '<input type="hidden" name="id" value="'.$ct['id_article'].'" /><input type="text" value="'.$ct['title'].'" name="titre"/>';
                        echo '<textarea rows="3" cols="50" name="contenu">'. $ct['content'] .'</textarea>';
                        echo '<a href="#content" class="read-more">En savoir plus</a>';
                        echo '<button class="btn-save" type="submit">Enregistrer les modifications</button></form></section>';
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
                        echo '<a href="#content" class="read-more">En savoir plus</a>';
                        echo '</section>';
                        break;
                    default:
                        break;
                }
            }
        }
    }

    /**
     * Génère les articles de la page en fonction des templates existantes.
     * @throws Exception
     */
    public function genererArticles(): void
    {
        $content = $this->pageControlleur->genererContenu();
        if (isset($_SESSION['admin'])) {
            if ($this->pageControlleur->getName() == 'Homepage') {
                echo '  <div class="articles-grid">';
                $pl = 0;
                foreach ($content as $ct) {
                    if ($ct['type'] == 'homepage') {
                        $pl = $ct['placement'];
                        echo "<form action='/PageControlleur/ajouterArticle' method='post'><input type='hidden' name='placement' value='".$pl."'/><input type='hidden' name='name' value='".$this->pageControlleur->getName()."'/><input type='hidden' name='type' value='homepage'/>
                        <select name='choix' id='article-type'>
                            <option value='made'>créer un article</option>
                            <option value='linked'>importer un article<br><input type='text' name='link'/></option>
                        </select>
                        <button type='submit' name='add'>Ajouter un article</button></form>";
                        echo '<div class="article-preview"><div class="article-content">';
                        echo '<img src="/PageControlleur/getImage?id='.$ct['id_article'].'" alt="'.$ct['title'].'" onerror="this.style.display=\'none\';">';
                        echo '<form action="/PageControlleur/deleteImage" method="post"><input type="hidden" name="name" value="'.$this->pageControlleur->getName().'"/><button class="btn-delete" type="submit" name="delete" value="'. $ct['id_article'] . '">Supprimer l\'image</button></form>';
                        echo '<form action="/PageControlleur/updateImage" method="post" enctype="multipart/form-data">';
                        echo '<input type="hidden" name="id" value="'.$ct['id_article'].'">';
                        echo '<label for="file-'.$ct['id_article'].'" class="dropzone">Glissez & déposez une image ou cliquez ici</label>';
                        echo '<input type="file" id="file-'.$ct['id_article'].'" name="image" accept="image/*" onchange="this.form.submit()" style="display: none;">';
                        echo '<input type="hidden" name="name" value="'.$this->pageControlleur->getName().'"/>';
                        echo '</form>';
                        echo '<form action="/PageControlleur/updateArticle" method="post"><input type="hidden" name="name" value="'.$this->pageControlleur->getName().'"/>';
                        echo '<input type="hidden" name="id" value="'.$ct['id_article'].'"/><input type="text" value="'.$ct['title'].'" name="titre"/>';
                        echo '<textarea rows="3" cols="50" name="contenu">'. $ct['content'] .'</textarea>';
                        echo '<a href="' . $ct['link'] . '" class="read-more">En savoir plus</a>';
                        echo "<button class='btn-save' type='submit'>Enregistrer les modifications</button></form><form action='/PageControlleur/deleteArticle' method='POST'><input type='hidden' name='action' value='delete'><input type='hidden' name='link' value='".$ct['link']. "'><input type='hidden' name='type' value='".$ct['type']. "'><input type='hidden' name='name' value='".$this->pageControlleur->getName()."'/><button class='btn-delete' type='submit' name='delete' value='". $ct['id_article'] . "'>Supprimer l'article</button></form></div>";
                        echo '</div>';
                    }
                }
                $pl++;
                echo "<form action='/PageControlleur/ajouterArticle' method='post'><input type='hidden' name='placement' value='".$pl."'/><input type='hidden' name='name' value='".$this->pageControlleur->getName()."'/><input type='hidden' name='type' value='homepage'/><button type='submit' name='add'>Ajouter un article</button></form>";
                echo '</div>';
                $pl++;
                $this->genererNewArticle($pl);
            } elseif ($this->pageControlleur->getName()== 'menu') {
                echo '<div class="panel-container">';
                $pl = 0;
                foreach ($content as $ct) {
                    if ($ct['type'] == 'menu') {
                        $pl = $ct['placement'];
                        echo "<form action='/PageControlleur/ajouterArticle' method='post'><input type='hidden' name='placement' value='".$pl."'/><input type='hidden' name='name' value='".$this->pageControlleur->getName()."'/><input type='hidden' name='type' value='menu'/>
                        <select name='choix' id='article-type'>
                            <option value='made'>créer un article</option>
                            <option value='linked'>importer un article<br><input type='text' name='link'/></option>
                        </select>
                        <button type='submit' name='add'>Ajouter un article</button></form>";
                        echo '<div class="feature"><form action="/PageControlleur/updateArticle" method="post"><input type="hidden" name="name" value="'.$this->pageControlleur->getName().'"/><input type="hidden" name="id" value="'.$ct['id_article'].'"/>';
                        echo '<textarea rows="3" cols="50" name="titre">'. $ct['title'] .'</textarea>';
                        echo '<button class="btn-save" type="submit">Enregistrer les modifications</button></form>';
                        echo "<form action='/PageControlleur/deleteArticle' method='POST'><input type='hidden' name='action' value='delete'><input type='hidden' name='link' value='".$ct['link']. "'><input type='hidden' name='type' value='".$ct['type']. "'><input type='hidden' name='name' value='".$this->pageControlleur->getName()."'/><button class='btn-delete' type='submit' name='delete' value='". $ct['id_article'] . "'>Supprimer l'article</button></form>";
                        echo '<a href="' . $ct['link'] . '" class="read-more">Accéder à la page</a>';
                        echo '</div>';
                    }
                }
                $pl++;
                echo "<form action='/PageControlleur/ajouterArticle' method='post'><input type='hidden' name='placement' value='".$pl."'/><input type='hidden' name='name' value='".$this->pageControlleur->getName()."'/><input type='hidden' name='type' value='menu'/><button type='submit' name='add'>Ajouter un article</button></form>";
                echo '</div>';
                $pl++;
                $this->genererNewArticle($pl);
            }

            if ($content[0] != null) {
                echo '<section id="content" class="department-content">';
            }
            $cptlink = 1;
            $tmp = '';
            foreach ($content as $ct) {
                if (preg_match('/^list(\d+)$/', $ct['type'])) {
                    if ($ct['type'] == $tmp) {
                        continue;
                    }
                    $tmp = $ct['type'];
                    $cpt2 = 0;
                    $pl = 0;
                    echo '<div class="features-grid">';
                    foreach ($content as $ct2) {
                        if ($ct2['type'] == $ct['type']) {
                            $pl = $ct2['placement'];
                            echo '<div class="feature">';
                            echo '<img src="/PageControlleur/getImage?id=' . $ct2['id_article'] . '" alt="' . $ct2['title'] . '" onerror="this.style.display=\'none\';"">';
                            echo '<form action="/PageControlleur/deleteImage" method="post"><input type="hidden" name="name" value="' . $this->pageControlleur->getName() . '"/><button class="btn-delete" type="submit" name="delete" value="' . $ct2['id_article'] . '">Supprimer l\'image</button></form>';
                            echo '<form action="/PageControlleur/updateImage" method="post" enctype="multipart/form-data">';
                            echo '<input type="hidden" name="id" value="' . $ct2['id_article'] . '">';
                            echo '<label for="file-' . $ct2['id_article'] . '" class="dropzone">Glissez & déposez une image ou cliquez ici</label>';
                            echo '<input type="file" id="file-' . $ct2['id_article'] . '" name="image" accept="image/*" onchange="this.form.submit()" style="display: none;">';
                            echo '<input type="hidden" name="name" value="' . $this->pageControlleur->getName() . '"/>';
                            echo '</form>';
                            echo '<form action="/PageControlleur/updateArticle" method="post"><input type="hidden" name="name" value="' . $this->pageControlleur->getName() . '"/>';
                            echo '<input type="hidden" name="id" value="' . $ct2['id_article'] . '"/><input type="text" value="' . $ct2['title'] . '" name="titre"/>';
                            echo '<textarea rows="3" cols="50" name="contenu">' . $ct2['content'] . '</textarea>';
                            echo '<button class="btn-save" type="submit">Enregistrer les modifications</button></form>';
                            echo "<form action='/PageControlleur/deleteArticle' method='POST'><input type='hidden' name='action' value='delete'><input type='hidden' name='type' value='" . $ct['type'] . "'><input type='hidden' name='name' value='" . $this->pageControlleur->getName() . "'/><button class='btn-delete' type='submit' name='delete' value='" . $ct2['id_article'] . "'>Supprimer l'article</button></form>";
                            echo '</div>';
                            $cpt2++;
                                }
                            }
                            for ($i = 0; $i < $cpt2; $i++) {
                                array_shift($content);
                            }
                            $type = $ct['type'];
                            $pl++;
                    echo '<form action="/PageControlleur/ajouterArticle" method="post"><input type="hidden" name="placement" value="'.$pl.'"/><input type="hidden" name="name" value="' . $this->pageControlleur->getName() . '"/><input type="hidden" name="type" value="' . $type . '"/><button type="submit" name="add">Ajouter un article</button></form>';
                            echo '</div>';
                            $pl++;
                            $this->genererNewArticle($pl);
                }
                else if (preg_match('/^lstlinked(\d+)$/', $ct['type'])) {
                    if ($ct['type'] == $tmp) {
                        continue;
                    }
                    $tmp = $ct['type'];
                    $pl = 0;
                    $cpt2 = 0;
                    echo '<div class="features-grid">';
                    foreach ($content as $ct2) {
                        if ($ct2['type'] == 'lstlinked' . $cptlink) {
                            echo '<div class="feature">';
                            echo '<img src="/PageControlleur/getImage?id=' . $ct2['id_article'] . '" alt="' . $ct2['title'] . '" onerror="this.style.display=\'none\';">';
                            echo '<form action="/PageControlleur/deleteImage" method="post"><input type="hidden" name="name" value="' . $this->pageControlleur->getName() . '"/><button class="btn-delete" type="submit" name="delete" value="' . $ct2['id_article'] . '">Supprimer l\'image</button></form>';
                            echo '<form action="/PageControlleur/updateImage" method="post" enctype="multipart/form-data">';
                            echo '<input type="hidden" name="id" value="' . $ct2['id_article'] . '">';
                            echo '<label for="file-' . $ct2['id_article'] . '" class="dropzone">Glissez & déposez une image ou cliquez ici</label>';
                            echo '<input type="file" id="file-' . $ct2['id_article'] . '" name="image" accept="image/*" onchange="this.form.submit()" style="display: none;">';
                            echo '<input type="hidden" name="name" value="' . $this->pageControlleur->getName() . '"/>';
                            echo '</form>';
                            echo '<form action="/PageControlleur/updateArticle" method="post"><input type="hidden" name="name" value="' . $this->pageControlleur->getName() . '"/>';
                            echo '<input type="hidden" name="id" value="' . $ct2['id_article'] . '"/><input type="text" value="' . $ct2['title'] . '" name="titre"/>';
                            echo '<textarea rows="3" cols="50" name="contenu">' . $ct2['content'] . '</textarea><textarea rows="3" cols="50" name="lien">' . $ct2['link'] . '</textarea>';
                            echo '<button class="btn-save" type="submit">Enregistrer les modifications</button></form>';
                            echo "<form action='/PageControlleur/deleteArticle' method='POST'><input type='hidden' name='action' value='delete'><input type='hidden' name='type' value='" . $ct['type'] . "'><input type='hidden' name='name' value='" . $this->pageControlleur->getName() . "'/><button class='btn-delete' type='submit' name='delete' value='" . $ct2['id_article'] . "'>Supprimer l'article</button></form>";
                            echo '</div>';
                            $cpt2++;
                            $pl = $ct2['placement'];
                        }
                    }
                    for ($i = 0; $i < $cpt2; $i++) {
                        array_shift($content);
                    }
                    $type = $ct['type'];
                    $pl++;
                    echo '<form action="/PageControlleur/ajouterArticle" method="post"><input type="hidden" name="placement" value="'.$pl.'"/><input type="hidden" name="name" value="' . $this->pageControlleur->getName() . '"/><input type="hidden" name="type" value="' . $type . '"/><button type="submit" name="add">Ajouter un article</button></form>';
                    echo '</div>';
                    $cptlink++;
                    $pl++;
                    $this->genererNewArticle($pl);
                }
                else {
                    switch ($ct['type']) {
                        case 'texte':
                            echo '<div class="intro"><form action="/PageControlleur/updateArticle" method="post"><input type="hidden" name="name" value="' . $this->pageControlleur->getName() . '"/>';
                            echo '<input type="hidden" name="id" value="' . $ct['id_article'] . '" /><input type="text" value="' . $ct['title'] . '" name="titre"/>';
                            echo '<textarea rows="3" cols="50" name="contenu">' . $ct['content'] . '</textarea>';
                            echo '<button class="btn-save" type="submit">Enregistrer les modifications</button></form>';
                            echo "<form action='/PageControlleur/deleteArticle' method='POST'><input type='hidden' name='action' value='delete'><input type='hidden' name='type' value='" . $ct['type'] . "'><input type='hidden' name='name' value='" . $this->pageControlleur->getName() . "'/><button class='btn-delete' type='submit' name='delete' value='" . $ct['id_article'] . "'>Supprimer l'article</button></form>";
                            echo '</div>';
                            $pl = $ct['placement'];
                            $pl++;
                            $this->genererNewArticle($pl);
                            break;
                        case 'titre':
                            echo '<form action="/PageControlleur/updateArticle" method="post"><input type="hidden" name="name" value="' . $this->pageControlleur->getName() . '"/><input type="hidden" name="id" value="' . $ct['id_article'] . '"/><input type="text" value="' . $ct['title'] . '" name="titre"/><button class="btn-save" type="submit">Enregistrer les modifications</button></form>';
                            echo "<form action='/PageControlleur/deleteArticle' method='POST'><input type='hidden' name='action' value='delete'><input type='hidden' name='type' value='" . $ct['type'] . "'><input type='hidden' name='name' value='" . $this->pageControlleur->getName() . "'/><button class='btn-delete' type='submit' name='delete' value='" . $ct['id_article'] . "'>Supprimer l'article</button></form>";
                            $pl = $ct['placement'];
                            $pl++;
                            $this->genererNewArticle($pl);
                            break;
                        case 'lien':
                            echo '<div><form action="/PageControlleur/updateArticle" method="post"><input type="hidden" name="name" value="' . $this->pageControlleur->getName() . '"/><input type="hidden" name="id" value="' . $ct['id_article'] . '"/><textarea rows="3" cols="50" name="lien">' . $ct['link'] . '</textarea><textarea rows="3" cols="50" name="contenu">' . $ct['content'] . '</textarea><button class="btn-save" type="submit">Enregistrer les modifications</button></form>';
                            echo "<form action='/PageControlleur/deleteArticle' method='POST'><input type='hidden' name='action' value='delete'><input type='hidden' name='type' value='" . $ct['type'] . "'><input type='hidden' name='name' value='" . $this->pageControlleur->getName() . "'/><button class='btn-delete' type='submit' name='delete' value='" . $ct['id_article'] . "'>Supprimer l'article</button></form>";
                            echo '</div>';
                            $pl = $ct['placement'];
                            $pl++;
                            $this->genererNewArticle($pl);
                            break;
                        case 'paragraphe':
                            echo '<div><form action="/PageControlleur/updateArticle" method="post"><input type="hidden" name="name" value="' . $this->pageControlleur->getName() . '"/><input type="hidden" name="id" value="' . $ct['id_article'] . '"/><textarea rows="3" cols="50" name="contenu">' . $ct['content'] . '</textarea><button class="btn-save" type="submit">Enregistrer les modifications</button></form>';
                            echo "<form action='/PageControlleur/deleteArticle' method='POST'><input type='hidden' name='action' value='delete'><input type='hidden' name='type' value='" . $ct['type'] . "'><input type='hidden' name='name' value='" . $this->pageControlleur->getName() . "'/><button class='btn-delete' type='submit' name='delete' value='" . $ct['id_article'] . "'>Supprimer l'article</button></form>";
                            echo '</div>';
                            $pl = $ct['placement'];
                            $pl++;
                            $this->genererNewArticle($pl);
                            break;
                        case 'img':
                            echo '<div>';
                            echo '<img src="/PageControlleur/getImage?id=' . $ct['id_article'] . '" alt="' . $ct['title'] . '" onerror="this.style.display=\'none\';">';
                            echo '<form action="/PageControlleur/deleteImage" method="post"><input type="hidden" name="name" value="' . $this->pageControlleur->getName() . '"/><button class="btn-delete" type="submit" name="delete" value="' . $ct['id_article'] . '">Supprimer l\'image</button></form>';
                            echo '<form action="/PageControlleur/updateImage" method="post" enctype="multipart/form-data">';
                            echo '<input type="hidden" name="id" value="' . $ct['id_article'] . '">';
                            echo '<label for="file-' . $ct['id_article'] . '" class="dropzone">Glissez & déposez une image ou cliquez ici</label>';
                            echo '<input type="file" id="file-' . $ct['id_article'] . '" name="image" accept="image/*" onchange="this.form.submit()" style="display: none;">';
                            echo '<input type="hidden" name="name" value="' . $this->pageControlleur->getName() . '"/>';
                            echo '</form>';
                            echo "<form action='/PageControlleur/deleteArticle' method='POST'><input type='hidden' name='type' value='" . $ct['type'] . "'><input type='hidden' name='action' value='delete'><input type='hidden' name='name' value='" . $this->pageControlleur->getName() . "'/><button class='btn-delete' type='submit' name='delete' value='" . $ct['id_article'] . "'>Supprimer l'article</button></form>";
                            echo '</div>';
                            $pl = $ct['placement'];
                            $pl++;
                            $this->genererNewArticle($pl);
                            break;
                        case 'pdf':
                            echo '<div>';
                            echo '<a href="/PageControlleur/getPdf?id=' . $ct['id_article'] . '" download="fichier.pdf">Télécharger le PDF</a>';
                            echo '<form action="/PageControlleur/updatePdf" method="post" enctype="multipart/form-data">';
                            echo '<input type="hidden" name="id" value="' . $ct['id_article'] . '">';
                            echo '<label for="file-' . $ct['id_article'] . '" class="dropzone">Glissez & déposez un fichier PDF ou cliquez ici</label>';
                            echo '<input type="file" id="file-' . $ct['id_article'] . '" name="file" accept="file/pdf" onchange="this.form.submit()" style="display: none;">';
                            echo '<input type="hidden" name="name" value="' . $this->pageControlleur->getName() . '"/>';
                            echo '</form>';
                            echo "<form action='/PageControlleur/deleteArticle' method='POST'><input type='hidden' name='type' value='" . $ct['type'] . "'><input type='hidden' name='action' value='delete'><input type='hidden' name='name' value='" . $this->pageControlleur->getName() . "'/><button class='btn-delete' type='submit' name='delete' value='" . $ct['id_article'] . "'>Supprimer l'article</button></form>";
                            echo '</div>';
                            $pl = $ct['placement'];
                            $pl++;
                            $this->genererNewArticle($pl);
                            break;
                        case 'useraccess':
                            echo '<div class="panel" onclick="window.location.href=\'' . $ct['link'] . '\';">';
                            echo '<h2>' . $ct['title'] . '</h2>';
                            echo '</div>';
                            break;
                        case 'gestion' :
                            echo '<div class="gestion"><h1> Ajouter un utilisateur </h1><form action="/PageControlleur/ajouterUser" method="post"><input type="hidden" name="page" value="' . $this->pageControlleur->getName() . '"/><h2>email</h2><input type="text" value="" name="email"/><h2>Nom d\'utilisateur</h2><input type="text" value="" name="name"/><h2>annee</h2><input type="text" value="" name="annee"/><h2>groupe</h2><input type="text" value="" name="groupe"/><button class="btn-save" type="submit">Enregistrer les modifications</button></form>';
                            echo '</div>';
                            echo '<div class="gestion"><h1> Supprimer un utilisateur </h1><form action="/PageControlleur/supprimerUser" method="post"><input type="hidden" name="page" value="' . $this->pageControlleur->getName() . '"/><h2>email</h2><input type="text" value="" name="email"/><button class="btn-save" type="submit">Supprimer l\'utilisateur</button></form>';
                            echo '</div>';
                            break;
                        case 'youtube':
                            echo '<div class="video-container"><iframe width="560" height="315" src="https://www.youtube.com/embed/sVoBk3g-ZmA?si=_GRzxx9eprOXzGQ4" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe></div>';
                            break;
                        default:
                            break;
                    }
                }
            }
        }
        else {
            if ($this->pageControlleur->getName() == 'Homepage') {
                echo '  <div class="articles-grid">';
                foreach ($content as $ct) {
                    if ($ct['type'] == 'homepage') {
                        echo '<div class="article-preview">';
                        echo '<img src="/PageControlleur/getImage?id=' . $ct['id_article'] . '" alt="' . htmlspecialchars($ct['title'], ENT_QUOTES) . '" class="article-image" onerror="this.style.display=\'none\';">';
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
                                echo '<img src="/PageControlleur/getImage?id='.$ct2['id_article'].'" alt="'.$ct2['title'].'" onerror="this.style.display=\'none\';">';
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
                        echo '<div class="contour" ><a class="link" href="' . $ct['link'] . '" >'.$ct['content'].'</a></div>';
                        break;
                    case 'paragraphe':
                        echo '<div><p>' . $ct['content'] . '</p></div>';
                        break;
                    case 'image':
                        echo '<div>';
                        echo '<img src="/PageControlleur/getImage?id='.$ct['id_article'].'" alt="'.$ct['title'].'" onerror="this.style.display=\'none\';">';
                        echo '</div>';
                        break;
                    case 'lstlinked' . $cptlink :
                        $cpt2 = 0;
                        echo '<div class="features-grid">';
                        foreach ($content as $ct2) {
                            if ($ct2['type'] == 'lstlinked' . $cptlink) {
                                echo '<div class="feature">';
                                echo '<img src="/PageControlleur/getImage?id='.$ct2['id_article'].'" alt="'.$ct2['title'].'" onerror="this.style.display=\'none\';">';
                                echo '<h3>' . $ct2['title'] . '</h3>';
                                echo '<p>' . $ct2['content'] . '</p>';
                                echo '<a href="' . $ct['link'] . '"  class="read-more">En savoir plus</a>';
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
                    case 'youtube':
                        echo '<div class="video-container"><iframe width="560" height="315" src="https://www.youtube.com/embed/sVoBk3g-ZmA?si=_GRzxx9eprOXzGQ4" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe></div>';
                            break;
                    default:
                        break;
                }
            }
        }
    }

    /**
     * Génère un formulaire pour ajouter un article.
     * @throws Exception
     */
    public function genererNewArticle($placement): void
    {
        $cpts = $this->pageControlleur->recupererListe();
        echo '<section id="content"><div class="gestion"><form action="/PageControlleur/ajouterArticle" method="post"  enctype="multipart/form-data"><input type="hidden" name="name" value="'.$this->pageControlleur->getName().'"/>';
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
        echo '<input type="hidden" name="placement" value="' .$placement .'"/>';
        echo "<button type='submit' name='add'>Ajouter l'article</button></form></div></section>";
    }


    /**
     * Affiche la page.
     * @throws Exception
     */
    public function show(): void
    {
        ob_start();
        echo '<script src="/assets/js/page.js"></script>';
        $page = $this->pageControlleur->genererTitre();
        $this->genererIntro();
        $this->genererArticles();

        (new Layout($page[0]['pagetitle'], ob_get_clean()))->show();

    }
}