<?php

namespace App\src\views\pages;

use App\src\controllers\pages\PageControlleur;
use DateTime;
use DateTimeZone;
use Exception;
use Sabre\VObject;
/**
 * Class Show
 * @package App\src\views\pages
 */
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
     * @throws Exception
     */
    public function genererIntro(): void
    {
        $content = $this->pageControlleur->genererContenu();
        echo '<link rel="stylesheet" href="/assets/styles/page.css"><main>';
        if (isset($_SESSION['admin']) && $_SESSION['admin']) {
            foreach ($content as $ct) {
                switch ($ct['type']) {
                    case 'banderolle':
                        echo '<div class="marqueee"><p style="text-align: left; color: #4c4c4c">banderolle</p><br><form action="/PageControlleur/updateArticle" method="post"><input type="hidden" name="name" class="admin-input" value="'.$this->pageControlleur->getName().'"/>';
                        echo '';
                        echo '<input type="hidden" class="admin-input" name="id" value="'.$ct['id_article'].'" /><input type="text" value="'.$ct['title'].'" name="titre"/>';
                        echo '<button class="btn-save" type="submit"><i class="fa-solid fa-floppy-disk"></i></button></form>';
                        echo "<form action='/PageControlleur/deleteArticle' method='POST' style='text-align: center;' onsubmit='return confirm(\"Êtes-vous sûr de vouloir supprimer cet article ? Cette action est irréversible.\")'><input type='hidden' name='action' value='delete'><input type='hidden' name='type' value='".$ct['type']. "'><input type='hidden' name='name' value='".$this->pageControlleur->getName()."'/><button class='btn-delete' type='submit' name='delete' value='". $ct['id_article'] . "'><i class='fa-solid fa-trash'></i></button></form></div>";
                        break;
                    case 'intro':
                        echo ' <section class="hero-section"><div class="hero-content"><p style="text-align: left; color: #4c4c4c">intro</p><br>';
                        echo '<form action="/PageControlleur/updateArticle" method="post"><input type="hidden" name="name" value="'.$this->pageControlleur->getName().'"/>';
                        echo '<input type="hidden" name="id" value="'.$ct['id_article'].'" /><input type="text" class="admin-input" value="'.$ct['title'].'" name="titre"/>';
                        echo '<textarea rows="3" cols="50" name="contenu">'. $ct['content'] .'</textarea>';
                        echo '<a href="#content" class="read-more">En savoir plus</a>';
                        echo '<button class="btn-save" type="submit"><i class="fa-solid fa-floppy-disk"></i></button></form></section>';
                        break;
                    default:
                        break;
                }
            }
            if ($this->pageControlleur->getName() != 'Homepage' && $this->pageControlleur->getName() != 'User' && $this->pageControlleur->getName() != 'menu'){
                $this->genererNewArticle(2);
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
                        echo '<div class="add-article">';
                        echo "<form action='/PageControlleur/ajouterArticle' method='post'><input type='hidden' name='placement' value='" . $pl . "'/><input type='hidden' name='name' value='" . $this->pageControlleur->getName() . "'/><input type='hidden' name='type' value='homepage'/>
                        <select name='choix' id='article-type'>
                          <option value='made'>Créer un article</option>
                        <option value='linked'>Importer un article</option>
                        </select><br>
                        <input type='text' name='link'  id='link-input' style='align-self: center; display: none;' placeholder='Entrez le lien'/>
                           <button type='submit' style='justify-self: center;' name='add'>+</button></form></div>";
                        echo '<div class="article-preview"><div class="article-content"><p style="text-align: left; color: #4c4c4c">article homepage</p><br>';
                        echo '<img src="/PageControlleur/getImage?id='.$ct['id_article'].'" alt="'.$ct['title'].'" onerror="this.style.display=\'none\';">';
                        echo '<form action="/PageControlleur/deleteImage" method="post" onsubmit="return confirm(\'Êtes-vous sûr de vouloir supprimer cette image ? Cette action est irréversible.\')"><input type="hidden" name="name" value="'.$this->pageControlleur->getName().'"/><button class="btn-delete" type="submit" name="delete" value="'. $ct['id_article'] . '"><i class="fa-solid fa-trash"></i></button></form>';
                        echo '<form action="/PageControlleur/updateImage" method="post" enctype="multipart/form-data">';
                        echo '<input type="hidden" name="id" value="'.$ct['id_article'].'">';
                        echo '<label for="file-'.$ct['id_article'].'" class="dropzone">Glissez & déposez une image ou cliquez ici</label>';
                        echo '<input type="file" id="file-'.$ct['id_article'].'" name="image" accept="image/*" onchange="this.form.submit()" style="display: none;">';
                        echo '<input type="hidden" name="name" value="'.$this->pageControlleur->getName().'"/>';
                        echo '</form>';
                        echo '<form action="/PageControlleur/updateArticle" method="post"><input type="hidden" name="name" value="'.$this->pageControlleur->getName().'"/>';
                        echo '<input type="hidden" name="id" value="'.$ct['id_article'].'"/><input type="text" class="admin-input" value="'.$ct['title'].'" name="titre"/>';
                        echo '<textarea rows="3" cols="50" name="contenu">'. $ct['content'] .'</textarea>';
                        echo '<a href="' . $ct['link'] . '" class="read-more">En savoir plus</a><br><br>';
                        echo "<button class='btn-save' type='submit'><i class='fa-solid fa-floppy-disk'></i></button></form><form action='/PageControlleur/deleteArticle' method='POST' onsubmit='return confirm(\"Êtes-vous sûr de vouloir supprimer cet article ? Cette action est irréversible.\")'><input type='hidden' name='action' value='delete'><input type='hidden' name='link' value='".$ct['link']. "'><input type='hidden' name='type' value='".$ct['type']. "'><input type='hidden' name='name' value='".$this->pageControlleur->getName()."'/><button class='btn-delete' type='submit' name='delete' value='". $ct['id_article'] . "'><i class='fa-solid fa-trash'></i></button></form></div>";
                        echo '</div>';
                    }
                }
                $pl++;
                echo "<form action='/PageControlleur/ajouterArticle' method='post'><input type='hidden' name='placement' value='".$pl."'/><input type='hidden' name='name' value='".$this->pageControlleur->getName()."'/><input type='hidden' name='type' value='homepage'/>
                        <select name='choix' id='article-type'>
                          <option value='made'>Créer un article</option>
                        <option value='linked'>Importer un article</option>
                        </select><br>
                        <input type='text' name='link' class='admin-input' id='link-input' style='display: none;' placeholder='Entrez le lien'/>
                           <button type='submit' name='add'>+</button></form>";
                echo '</div>';
                $pl++;
                $this->genererNewArticle($pl);
            } elseif ($this->pageControlleur->getName()== 'menu') {
                echo '<div class="panel-container">';
                $pl = 0;
                foreach ($content as $ct) {
                    if ($ct['type'] == 'menu') {
                        $pl = $ct['placement'];
                        echo "<form action='/PageControlleur/ajouterArticle' method='post' class='form'><input type='hidden' name='placement' value='".$pl."'/><input type='hidden' name='name' value='".$this->pageControlleur->getName()."'/><input type='hidden' name='type' value='menu'/>
                        <select name='choix' id='article-type'>
                          <option value='made'>Créer un article</option>
                        <option value='linked'>Importer un article</option>
                        </select><br>
                        <input type='text' name='link' id='link-input' class='admin-input' style='display: none;' placeholder='Entrez le lien'/>
                           <button type='submit' name='add'>+</button></form>";
                        echo '<div class="feature"><p style="text-align: left; color: #4c4c4c">article menu</p><br><form action="/PageControlleur/updateArticle" method="post"><input type="hidden" name="name" value="'.$this->pageControlleur->getName().'"/><input type="hidden" name="id" value="'.$ct['id_article'].'"/>';
                        echo '<textarea rows="3" cols="50" name="titre">'. $ct['title'] .'</textarea>';
                        echo '<button class="btn-save" type="submit"><i class="fa-solid fa-floppy-disk"></i></button></form>';
                        echo "<form action='/PageControlleur/deleteArticle' method='POST' onsubmit='return confirm(\"Êtes-vous sûr de vouloir supprimer cet article ? Cette action est irréversible.\")'><input type='hidden' name='action' value='delete'><input type='hidden' name='link' value='".$ct['link']. "'><input type='hidden' name='type' value='".$ct['type']. "'><input type='hidden' name='name' value='".$this->pageControlleur->getName()."'/><button class='btn-delete' type='submit' name='delete' value='". $ct['id_article'] . "'><i class='fa-solid fa-trash'></i></button></form>";
                        echo '<a href="' . $ct['link'] . '" class="read-more">Accéder à la page</a>';
                        echo '</div>';
                    }
                }
                $pl++;
                echo "<form action='/PageControlleur/ajouterArticle' method='post'><input type='hidden' name='placement' value='".$pl."'/><input type='hidden' name='name' value='".$this->pageControlleur->getName()."'/><input type='hidden' name='type' value='menu'/>
                        <select name='choix' id='article-type'>
                          <option value='made'>Créer un article</option>
                        <option value='linked'>Importer un article</option>
                        </select><br>
                        <input type='text' name='link' id='link-input' style='display: none;' placeholder='Entrez le lien'/>
                           <button type='submit' name='add'>+</button></form>";
                echo '</div>';
                $pl++;
                $this->genererNewArticle($pl);
            }

            if ($content[0] != null) {
                echo '<section id="content" class="department-content">';
            }
            $tmp = '';
            foreach ($content as $ct) {
                if (preg_match('/^list(\d+)$/', $ct['type'])) {
                    if ($ct['type'] == $tmp) {
                        continue;
                    }
                    $tmp = $ct['type'];
                    $cpt2 = 0;
                    $pl = 0;
                    echo '<p style="text-align: left; color: #4c4c4c">liste d\'articles</p><br><div class="features-grid">';
                    foreach ($content as $ct2) {
                        if ($ct2['type'] == $ct['type']) {
                            $pl = $ct2['placement'];
                            echo '<div class="feature"><p style="text-align: left; color: #4c4c4c">article de la liste</p><br>';
                            echo '<img src="/PageControlleur/getImage?id=' . $ct2['id_article'] . '" alt="' . $ct2['title'] . '" onerror="this.style.display=\'none\';"">';
                            echo '<form action="/PageControlleur/deleteImage" method="post" onsubmit="return confirm(\'Êtes-vous sûr de vouloir supprimer cette image ? Cette action est irréversible.\')"><input type="hidden" name="name" value="' . $this->pageControlleur->getName() . '"/><button class="btn-delete" type="submit" name="delete" value="' . $ct2['id_article'] . '"><i class="fa-solid fa-trash"></i></button></form>';
                            echo '<form action="/PageControlleur/updateImage" method="post" enctype="multipart/form-data">';
                            echo '<input type="hidden" name="id" value="' . $ct2['id_article'] . '">';
                            echo '<label for="file-' . $ct2['id_article'] . '" class="dropzone">Glissez & déposez une image ou cliquez ici</label>';
                            echo '<input type="file" id="file-' . $ct2['id_article'] . '" name="image" accept="image/*" onchange="this.form.submit()" style="display: none;">';
                            echo '<input type="hidden" name="name" value="' . $this->pageControlleur->getName() . '"/>';
                            echo '</form>';
                            echo '<form action="/PageControlleur/updateArticle" method="post"><input type="hidden" name="name" value="' . $this->pageControlleur->getName() . '"/>';
                            echo '<input type="hidden" name="id" value="' . $ct2['id_article'] . '"/><input type="text" class="admin-input" value="' . $ct2['title'] . '" name="titre"/>';
                            echo '<textarea rows="3" cols="50" name="contenu">' . $ct2['content'] . '</textarea>';
                            echo '<button class="btn-save" type="submit"><i class="fa-solid fa-floppy-disk"></i></button></form>';
                            echo "<form action='/PageControlleur/deleteArticle' method='POST' onsubmit='return confirm(\"Êtes-vous sûr de vouloir supprimer cet article ? Cette action est irréversible.\")'><input type='hidden' name='action' value='delete'><input type='hidden' name='type' value='" . $ct['type'] . "'><input type='hidden' name='name' value='" . $this->pageControlleur->getName() . "'/><button class='btn-delete' type='submit' name='delete' value='" . $ct2['id_article'] . "'><i class='fa-solid fa-trash'></i></button></form>";
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
                elseif (preg_match('/^lstlinked(\d+)$/', $ct['type'])) {
                    if ($ct['type'] == $tmp) {
                        continue;
                    }
                    $tmp = $ct['type'];
                    $pl = 0;
                    $cpt2 = 0;
                    echo '<div class="features-grid"><p style="text-align: left; color: #4c4c4c">liste d\'articles avec lien</p><br>';
                    foreach ($content as $ct2) {
                        if ($ct2['type'] == $ct['type']) {
                            echo '<div class="feature"><p style="text-align: left; color: #4c4c4c">article de la liste</p><br>';
                            echo '<img src="/PageControlleur/getImage?id=' . $ct2['id_article'] . '" alt="' . $ct2['title'] . '" onerror="this.style.display=\'none\';">';
                            echo '<form action="/PageControlleur/deleteImage" method="post" onsubmit="return confirm(\'Êtes-vous sûr de vouloir supprimer cette image ? Cette action est irréversible.\')"><input type="hidden" name="name" value="' . $this->pageControlleur->getName() . '"/><button class="btn-delete" type="submit" name="delete" value="' . $ct2['id_article'] . '"><i class="fa-solid fa-trash"></i></button></form>';
                            echo '<form action="/PageControlleur/updateImage" method="post" enctype="multipart/form-data">';
                            echo '<input type="hidden" name="id" value="' . $ct2['id_article'] . '">';
                            echo '<label for="file-' . $ct2['id_article'] . '" class="dropzone">Glissez & déposez une image ou cliquez ici</label>';
                            echo '<input type="file" id="file-' . $ct2['id_article'] . '" name="image" accept="image/*" onchange="this.form.submit()" style="display: none;">';
                            echo '<input type="hidden" name="name" value="' . $this->pageControlleur->getName() . '"/>';
                            echo '</form>';
                            echo '<form action="/PageControlleur/updateArticle" method="post"><input type="hidden" name="name" value="' . $this->pageControlleur->getName() . '"/>';
                            echo '<input type="hidden" name="id" value="' . $ct2['id_article'] . '"/><input class="admin-input" type="text" value="' . $ct2['title'] . '" name="titre"/>';
                            echo '<textarea rows="3" cols="50" name="contenu">' . $ct2['content'] . '</textarea><textarea rows="3" cols="50" name="lien">' . $ct2['link'] . '</textarea>';
                            echo '<button class="btn-save" type="submit"><i class="fa-solid fa-floppy-disk"></i></button></form>';
                            echo "<form action='/PageControlleur/deleteArticle' method='POST' onsubmit='return confirm(\"Êtes-vous sûr de vouloir supprimer cet article ? Cette action est irréversible.\")'><input class='admin-input' type='hidden' name='action' value='delete'><input type='hidden' name='type' value='" . $ct['type'] . "'><input type='hidden' name='name' value='" . $this->pageControlleur->getName() . "'/><button class='btn-delete' type='submit' name='delete' value='" . $ct2['id_article'] . "'><i class='fa-solid fa-trash'></i></button></form>";
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
                    $pl++;
                    $this->genererNewArticle($pl);
                }
                else {
                    switch ($ct['type']) {
                        case 'titre':
                            echo '<p style="text-align: left; color: #4c4c4c">titre</p><br><form action="/PageControlleur/updateArticle" method="post"><input type="hidden" name="name" value="' . $this->pageControlleur->getName() . '"/><input type="hidden" name="id" value="' . $ct['id_article'] . '"/><input type="text" class="admin-input" value="' . $ct['title'] . '" name="titre"/>';
                            echo "<select name='centrage' id='article-type'>";
                            switch ($ct['centrage']) {
                                case 'center':
                                    echo "<option value='center' selected>centré</option>
                                          <option value='justify'>justifié</option>
                                          <option value='left'>aligné à gauche</option>
                                          <option value='right'>aligné à droite</option>";
                                    break;
                                case 'justify':
                                    echo "<option value='center'>centré</option>
                                          <option value='justify' selected>justifié</option>
                                          <option value='left'>aligné à gauche</option>
                                          <option value='right'>aligné à droite</option>";
                                    break;
                                case 'left':
                                    echo "<option value='center'>centré</option>
                                          <option value='justify'>justifié</option>
                                          <option value='left' selected>aligné à gauche</option>
                                          <option value='right'>aligné à droite</option>";
                                    break;
                                case 'right':
                                    echo "<option value='center'>centré</option>
                                          <option value='justify'>justifié</option>
                                          <option value='left'>aligné à gauche</option>
                                          <option value='right' selected>aligné à droite</option>";
                                    break;
                                default:
                                    break;
                            }
                            echo "</select><br>";
                            echo '<button class="btn-save" type="submit"><i class="fa-solid fa-floppy-disk"></i></button></form>';
                            echo "<form action='/PageControlleur/deleteArticle' method='POST' onsubmit='return confirm(\"Êtes-vous sûr de vouloir supprimer cet article ? Cette action est irréversible.\")'><input type='hidden' name='action' value='delete'><input type='hidden' name='type' value='" . $ct['type'] . "'><input type='hidden' name='name' value='" . $this->pageControlleur->getName() . "'/><button class='btn-delete' type='submit' name='delete' value='" . $ct['id_article'] . "'><i class='fa-solid fa-trash'></i></button></form>";
                            $pl = $ct['placement'];
                            $pl++;
                            $this->genererNewArticle($pl);
                            break;
                        case 'lien':
                            echo '<div><p style="text-align: left; color: #4c4c4c">lien</p><br><form action="/PageControlleur/updateArticle" method="post"><input type="hidden" name="name" value="' . $this->pageControlleur->getName() . '"/><input type="hidden" name="id" value="' . $ct['id_article'] . '"/><textarea rows="3" cols="50" name="lien">' . $ct['link'] . '</textarea><textarea rows="3" cols="50" name="contenu">' . $ct['content'] . '</textarea>';
                            echo "<select name='centrage' id='article-type'>";
                            switch ($ct['centrage']) {
                                case 'center':
                                    echo "<option value='center' selected>centré</option>
                                          <option value='justify'>justifié</option>
                                          <option value='left'>aligné à gauche</option>
                                          <option value='right'>aligné à droite</option>";
                                    break;
                                case 'justify':
                                    echo "<option value='center'>centré</option>
                                          <option value='justify' selected>justifié</option>
                                          <option value='left'>aligné à gauche</option>
                                          <option value='right'>aligné à droite</option>";
                                    break;
                                case 'left':
                                    echo "<option value='center'>centré</option>
                                          <option value='justify'>justifié</option>
                                          <option value='left' selected>aligné à gauche</option>
                                          <option value='right'>aligné à droite</option>";
                                    break;
                                case 'right':
                                    echo "<option value='center'>centré</option>
                                          <option value='justify'>justifié</option>
                                          <option value='left'>aligné à gauche</option>
                                          <option value='right' selected>aligné à droite</option>";
                                    break;
                                default:
                                    break;
                            }
                            echo "</select><br>";
                            echo '<button class="btn-save" type="submit"><i class="fa-solid fa-floppy-disk"></i></button></form>';
                            echo "<form action='/PageControlleur/deleteArticle' method='POST' onsubmit='return confirm(\"Êtes-vous sûr de vouloir supprimer cet article ? Cette action est irréversible.\")'><input type='hidden' name='action' value='delete'><input type='hidden' name='type' value='" . $ct['type'] . "'><input type='hidden' name='name' value='" . $this->pageControlleur->getName() . "'/><button class='btn-delete' type='submit' name='delete' value='" . $ct['id_article'] . "'><i class='fa-solid fa-trash'></i></button></form>";
                            echo '</div>';
                            $pl = $ct['placement'];
                            $pl++;
                            $this->genererNewArticle($pl);
                            break;
                        case 'paragraphe':
                            echo '<div><p style="text-align: left; color: #4c4c4c">paragraphe</p><br><form action="/PageControlleur/updateArticle" method="post"><input type="hidden" name="name" value="' . $this->pageControlleur->getName() . '"/><input type="hidden" name="id" value="' . $ct['id_article'] . '"/><textarea rows="3" cols="50" name="contenu">' . $ct['content'] . '</textarea>';
                            echo "<select name='centrage' id='article-type'>";
                            switch ($ct['centrage']) {
                                case 'center':
                                    echo "<option value='center' selected>centré</option>
                                          <option value='justify'>justifié</option>
                                          <option value='left'>aligné à gauche</option>
                                          <option value='right'>aligné à droite</option>";
                                    break;
                                case 'justify':
                                    echo "<option value='center'>centré</option>
                                          <option value='justify' selected>justifié</option>
                                          <option value='left'>aligné à gauche</option>
                                          <option value='right'>aligné à droite</option>";
                                    break;
                                case 'left':
                                    echo "<option value='center'>centré</option>
                                          <option value='justify'>justifié</option>
                                          <option value='left' selected>aligné à gauche</option>
                                          <option value='right'>aligné à droite</option>";
                                    break;
                                case 'right':
                                    echo "<option value='center'>centré</option>
                                          <option value='justify'>justifié</option>
                                          <option value='left'>aligné à gauche</option>
                                          <option value='right' selected>aligné à droite</option>";
                                    break;
                                default:
                                    break;
                            }
                            echo "</select><br>";
                            echo '<button class="btn-save" type="submit"><i class="fa-solid fa-floppy-disk"></i></button></form>';
                            echo "<form action='/PageControlleur/deleteArticle' method='POST' onsubmit='return confirm(\"Êtes-vous sûr de vouloir supprimer cet article ? Cette action est irréversible.\")'><input type='hidden' name='action' value='delete'><input type='hidden' name='type' value='" . $ct['type'] . "'><input type='hidden' name='name' value='" . $this->pageControlleur->getName() . "'/><button class='btn-delete' type='submit' name='delete' value='" . $ct['id_article'] . "'><i class='fa-solid fa-trash'></i></button></form>";
                            echo '</div>';
                            $pl = $ct['placement'];
                            $pl++;
                            $this->genererNewArticle($pl);
                            break;
                        case 'img':
                            echo '<div><p style="text-align: left; color: #4c4c4c">image</p><br>';
                            echo '<img src="/PageControlleur/getImage?id=' . $ct['id_article'] . '" alt="' . $ct['title'] . '" onerror="this.style.display=\'none\';">';
                            echo '<form action="/PageControlleur/deleteImage" method="post" onsubmit="return confirm(\'Êtes-vous sûr de vouloir supprimer cette image ? Cette action est irréversible.\')"><input type="hidden" name="name" value="' . $this->pageControlleur->getName() . '"/><button class="btn-delete" type="submit" name="delete" value="' . $ct['id_article'] . '"><i class="fa-solid fa-trash"></i></button></form>';
                            echo '<form action="/PageControlleur/updateImage" method="post" enctype="multipart/form-data">';
                            echo '<input type="hidden" name="id" value="' . $ct['id_article'] . '">';
                            echo '<label for="file-' . $ct['id_article'] . '" class="dropzone">Glissez & déposez une image ou cliquez ici</label>';
                            echo '<input type="file" id="file-' . $ct['id_article'] . '" name="image" accept="image/*" onchange="this.form.submit()" style="display: none;">';
                            echo '<input type="hidden" name="name" value="' . $this->pageControlleur->getName() . '"/>';
                            echo '</form>';
                            echo "<form action='/PageControlleur/deleteArticle' method='POST' onsubmit='return confirm(\"Êtes-vous sûr de vouloir supprimer cet article ? Cette action est irréversible.\")'><input type='hidden' name='type' value='" . $ct['type'] . "'><input type='hidden' name='action' value='delete'><input type='hidden' name='name' value='" . $this->pageControlleur->getName() . "'/><button class='btn-delete' type='submit' name='delete' value='" . $ct['id_article'] . "'><i class='fa-solid fa-trash'></i></button></form>";
                            echo '</div>';
                            $pl = $ct['placement'];
                            $pl++;
                            $this->genererNewArticle($pl);
                            break;
                        case 'pdf':
                            echo '<div><p style="text-align: left; color: #4c4c4c">pdf</p><br>';
                            echo '<a href="/PageControlleur/getPdf?id=' . $ct['id_article'] . '" download="fichier.pdf">Télécharger le PDF</a>';
                            echo '<form action="/PageControlleur/updatePdf" method="post" enctype="multipart/form-data">';
                            echo '<input type="hidden" name="id" value="' . $ct['id_article'] . '">';
                            echo '<label for="file-' . $ct['id_article'] . '" class="dropzone">Glissez & déposez un fichier PDF ou cliquez ici</label>';
                            echo '<input type="file" id="file-' . $ct['id_article'] . '" name="file" accept="file/pdf" onchange="this.form.submit()" style="display: none;">';
                            echo '<input type="hidden" name="name" value="' . $this->pageControlleur->getName() . '"/>';
                            echo '</form>';
                            echo "<form action='/PageControlleur/deleteArticle' method='POST' onsubmit='return confirm(\"Êtes-vous sûr de vouloir supprimer cet article ? Cette action est irréversible.\")'><input type='hidden' name='type' value='" . $ct['type'] . "'><input type='hidden' name='action' value='delete'><input type='hidden' name='name' value='" . $this->pageControlleur->getName() . "'/><button class='btn-delete' type='submit' name='delete' value='" . $ct['id_article'] . "'><i class='fa-solid fa-trash'></i></button></form>";
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
                            echo '<br>';
                            echo '<div class="gestion"><h1> Ajouter un utilisateur </h1><form action="/PageControlleur/ajouterUser" method="post"><input type="hidden" name="page" value="' . $this->pageControlleur->getName() . '"/><h2>email</h2><input type="text" value="" name="email"/><h2>Nom d\'utilisateur</h2><input type="text" value="" name="name"/><h2>annee</h2><input type="text" value="" name="annee"/><h2>groupe</h2><input type="text" value="" name="groupe"/><button class="btn-save" type="submit">Enregistrer les modifications</button></form>';
                            echo '</div>';
                            echo '<br>';
                            echo '<div class="gestion"><h1> Supprimer un utilisateur </h1><form action="/PageControlleur/supprimerUser" method="post" onsubmit="return confirm(\'Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.\')"><input type="hidden" name="page" value="' . $this->pageControlleur->getName() . '"/><h2>email</h2><input type="text" value="" name="email"/><button class="btn-save" type="submit"><i class="fa-solid fa-trash"></i></button></form>';
                            echo '</div>';
                            echo '<br>';
                            break;
                        case 'youtube':
                            echo '<div class="video-container"><iframe width="560" height="315" src="https://www.youtube.com/embed/sVoBk3g-ZmA?si=_GRzxx9eprOXzGQ4" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe></div>';
                            break;
                        case 'csv' :
                            echo '<div class="gestion"><h1> Ajouter un fichier csv </h1><form action="/PageControlleur/ajouterCsv" method="post" enctype="multipart/form-data" id="dropzoneCsv"><input type="hidden" name="page" value="' . $this->pageControlleur->getName() . '"/><label for="file" class="dropzone">Glissez & déposez un fichier csv ou cliquez ici</label><input type="file" id="file" name="file" accept="file/csv" onchange="this.form.submit()" style="display: none;"><button class="btn-save" type="submit">Enregistrer les modifications</button></form>';
                            echo '</div>';
                            break;
                            case 'dlallusers' :
                                echo '<div class="gestion"><h1> Supprimer tous les utilisateurs</h1>';
                                echo '<form action="/PageControlleur/deleteAllUsers" method="post" onsubmit="return confirm(\'Êtes-vous sûr de vouloir supprimer tous les utilisateurs ? Cette action est irréversible.\')"><button class="btn-save" type="submit">Supprimer tous les utilisateurs</button></form>';
                                break;
                        case 'profile':
                            echo '<main>';
                            echo '<section class="profile">';
                            echo '<h1>Votre profil :</h1>';
                            echo '<h2>' . $_SESSION['name'] . '</h2>';

                            // Informations de profil
                            echo '<div class="profile-info">';
                            echo '<p><strong>Email:</strong> ' . $_SESSION['email'] . '</p>';
                            echo '<!-- Popup -->
                    <div class="popup" id="popup">
                        <div id="message-container">
                            <p id="error-message" style="color: red; display: none;"></p>

                            <!-- Message de succès -->
                            <p id="success-message" style="color: green; display: none;"></p>
                        </div>

                        <form id="password-form"  method="post">
                            <input type="hidden" name="name" value="'.$_SESSION['name'] .'">

                            <label>Mot de passe actuel :</label>
                            <div class="password-container">
                                <input type="password" id="mdpActuel" name="mdpActuel" required>
                                <button type="button" class="toggle-password" data-target="mdpActuel">👁️</button>
                            </div>

                            <label>Nouveau mot de passe :</label>
                            <div class="password-container">
                                <input type="password" id="nouveauMdp1" name="nouveauMdp1" required>
                                <button type="button" class="toggle-password" data-target="nouveauMdp1">👁️</button>
                            </div>

                            <label>Confirmer le nouveau mot de passe :</label>
                            <div class="password-container">
                                <input type="password" id="nouveauMdp2" name="nouveauMdp2" required>
                                <button type="button" class="toggle-password" data-target="nouveauMdp2">👁️</button>
                            </div>

                            <button class="btn-save" type="submit">Enregistrer les modifications</button>
                            <button class="btn-close" onclick="closePopup()">Fermer</button>
                        </form>

                    </div>';
                            echo '<a href="#" onclick="openPopup(); return false;" class="profile-btn">Modifier mon <br> mot de passe</a>';
                            echo '<br>';
                            echo '<a href="/logout" class="profile-btn">Déconnexion</a>';

                            echo '</div>';

                            echo '</section>';
                            echo '</main>';

                            echo '</body>';
                            echo '</html>';
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
                        echo '<h3 style="text-align:' . $ct['centrage'] . '">' . $ct['title'] . '</h3>';
                        echo '<p style="text-align:' . $ct['centrage'] . '">' . $ct['content'] . '</p>';
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
                        echo '<h2 style="text-align:' . $ct['centrage'] . '">' . $ct['title'] . '</h2>';
                        echo '</div>';
                    }
                }
                echo '</div>';
            }
            echo '<section id="content" class="department-content">';
            $tmp = '';
            foreach ($content as $ct) {
                if (preg_match('/^list(\d+)$/', $ct['type'])) {
                    if ($ct['type'] == $tmp) {
                        continue;
                    }
                    $tmp = $ct['type'];
                    $cpt2 = 0;
                    echo '<div class="features-grid">';
                    foreach ($content as $ct2) {
                        if ($ct2['type'] == $ct['type']) {
                            echo '<div class="feature">';
                            echo '<img src="/PageControlleur/getImage?id='.$ct2['id_article'].'" alt="'.$ct2['title'].'" onerror="this.style.display=\'none\';">';
                            echo '<h3 style="text-align:' . $ct['centrage'] . '">' . $ct2['title'] . '</h3>';
                            echo '<p style="text-align:' . $ct['centrage'] . '">' . $ct2['content'] . '</p>';
                            echo '</div>';
                            $cpt2++;
                        }
                    }
                    for ($i = 0; $i < $cpt2; $i++) {
                        array_shift($content);
                    }
                    echo '</div>';
                }
                elseif (preg_match('/^lstlinked(\d+)$/', $ct['type'])) {
                    if ($ct['type'] == $tmp) {
                        continue;
                    }
                    $tmp = $ct['type'];
                    $cpt2 = 0;
                    echo '<div class="features-grid">';
                    foreach ($content as $ct2) {
                        if ($ct2['type'] == $ct['type']) {
                            echo '<div class="feature">';
                            echo '<img src="/PageControlleur/getImage?id='.$ct2['id_article'].'" alt="'.$ct2['title'].'" onerror="this.style.display=\'none\';">';
                            echo '<h3 style="text-align:' . $ct['centrage'] . '">' . $ct2['title'] . '</h3>';
                            echo '<p style="text-align:' . $ct['centrage'] . '">' . $ct2['content'] . '</p>';
                            echo '<a href="' . $ct['link'] . '"  class="read-more" style="text-align:' . $ct['centrage'] . '">En savoir plus</a>';
                            echo '</div>';
                            $cpt2++;
                        }
                    }
                    for ($i = 0; $i < $cpt2; $i++) {
                        array_shift($content);
                    }
                    echo '</div>';
                }
                else {
                    switch ($ct['type']) {
                        case 'titre':
                            echo '<h2 style="text-align:' . $ct['centrage'] . '">' . $ct['title'] . '</h2>';
                            break;
                        case 'lien':
                            echo '<div class="contour" style="text-align:' . $ct['centrage'] . ';" ><a class="link" href="' . $ct['link'] . '" >' . $ct['content'] . '</a></div>';
                            break;
                        case 'paragraphe':
                            echo '<div><p style="text-align:' . $ct['centrage'] . '">' . $ct['content'] . '</p></div>';
                            break;
                        case 'img':
                            echo '<div>';
                            echo '<img src="/PageControlleur/getImage?id='.$ct['id_article'].'" alt="'.$ct['title'].'" onerror="this.style.display=\'none\';">';
                            echo '</div>';
                            break;
                        case 'pdf':
                            echo '<div>';
                            echo '<a href="/PageControlleur/getPdf?id=' . $ct['id_article'] . '" download="fichier.pdf">Télécharger le PDF</a>';
                            echo '</div>';
                            break;
                        case 'youtube':
                            echo '<div class="video-container"><iframe width="560" height="315" src="https://www.youtube.com/embed/sVoBk3g-ZmA?si=_GRzxx9eprOXzGQ4" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe></div>';
                            break;
                        case 'edt':
                            $urls = [
                                '1' => ['1' => 'https://ade-web-consult.univ-amu.fr/jsp/custom/modules/plannings/anonymous_cal.jsp?projectId=8&resources=8382&calType=ical&firstDate=2025-02-24&lastDate=2025-06-22',
                                    '2' => 'https://ade-web-consult.univ-amu.fr/jsp/custom/modules/plannings/anonymous_cal.jsp?projectId=8&resources=8380&calType=ical&firstDate=2025-02-24&lastDate=2025-06-22',
                                    '3' => 'https://ade-web-consult.univ-amu.fr/jsp/custom/modules/plannings/anonymous_cal.jsp?projectId=8&resources=8383&calType=ical&firstDate=2025-02-24&lastDate=2025-06-22',
                                    '4' => 'https://ade-web-consult.univ-amu.fr/jsp/custom/modules/plannings/anonymous_cal.jsp?projectId=8&resources=8381&calType=ical&firstDate=2025-02-24&lastDate=2025-06-22'],
                                '2' => ['A1' => 'https://ade-web-consult.univ-amu.fr/jsp/custom/modules/plannings/anonymous_cal.jsp?projectId=8&resources=8396&calType=ical&firstDate=2025-02-24&lastDate=2025-06-22',
                                    'A2' => 'https://ade-web-consult.univ-amu.fr/jsp/custom/modules/plannings/anonymous_cal.jsp?projectId=8&resources=8397&calType=ical&firstDate=2025-02-24&lastDate=2025-06-22',
                                    'B' => 'https://ade-web-consult.univ-amu.fr/jsp/custom/modules/plannings/anonymous_cal.jsp?projectId=8&resources=8398&calType=ical&firstDate=2025-02-24&lastDate=2025-06-22'],
                                '3' => ['A1' => 'https://ade-web-consult.univ-amu.fr/jsp/custom/modules/plannings/anonymous_cal.jsp?projectId=8&resources=42523&calType=ical&firstDate=2025-02-24&lastDate=2025-06-22',
                                    'A2' => 'https://ade-web-consult.univ-amu.fr/jsp/custom/modules/plannings/anonymous_cal.jsp?projectId=8&resources=42524&calType=ical&firstDate=2025-02-24&lastDate=2025-06-22',
                                    'B' => 'https://ade-web-consult.univ-amu.fr/jsp/custom/modules/plannings/anonymous_cal.jsp?projectId=8&resources=42525&calType=ical&firstDate=2025-02-24&lastDate=2025-06-22']
                            ];

                            $anneegroupe = $this->pageControlleur->getAnneeGroupe($_SESSION['name']);
                            $annee = $anneegroupe['annee'];
                            $groupe = $anneegroupe['groupe'];

                            // Vérification de l'existence de l'URL
                            $url = $urls[$annee][$groupe] ?? null;

                            if (!$url) {
                                echo '<p style="color: red;">Emploi du temps introuvable pour votre groupe.</p>';
                                break;
                            }

                            // Gestion du cache pour éviter les recharges inutiles
                            $cacheFile = "cache_edt_{$annee}_{$groupe}.ics";
                            if (!file_exists($cacheFile) || time() - filemtime($cacheFile) > 3600) {
                                $icsContent = @file_get_contents($url);
                                if ($icsContent) {
                                    file_put_contents($cacheFile, $icsContent);
                                } else {
                                    echo '<p style="color: red;">Impossible de récupérer l\'emploi du temps. Veuillez recharger la page.</p>';
                                    break;
                                }
                            } else {
                                $icsContent = file_get_contents($cacheFile);
                            }

                            // Lecture et parsing du fichier ICS
                            try {
                                $vcalendar = VObject\Reader::read($icsContent);
                            } catch (Exception $e) {
                                echo '<p style="color: red;">Erreur lors du chargement de l\'emploi du temps.</p>';
                                break;
                            }
                            // Préparation des événements triés par jour
                            $eventsByDay = ["Lundi" => [], "Mardi" => [], "Mercredi" => [], "Jeudi" => [], "Vendredi" => [], "Samedi" => [], "Dimanche" => []];
                            $daysMap = ["Monday" => "Lundi", "Tuesday" => "Mardi", "Wednesday" => "Mercredi", "Thursday" => "Jeudi", "Friday" => "Vendredi", "Saturday" => "Samedi", "Sunday" => "Dimanche"];

                            $today = new DateTime();
                            $startOfWeek = clone $today;
                            $startOfWeek->modify('monday this week');
                            $endOfWeek = clone $today;
                            $endOfWeek->modify('sunday this week');

                            foreach ($vcalendar->VEVENT as $event) {
                                $summary = (string)$event->SUMMARY;
                                $description = isset($event->DESCRIPTION) ? (string)$event->DESCRIPTION : "Aucune description";
                                $location = isset($event->LOCATION) ? (string)$event->LOCATION : "Lieu inconnu";

                                // Extraction du nom du professeur depuis la description
                                $professor = "Professeur inconnu ou non spécifié";
                                if (preg_match("/\n([A-ZÉÀÔÛÎÏËÖÜÇ-]+ [A-ZÉÀÔÛÎÏËÖÜÇ]+[a-zéèàôûîïëöüç]*)/", $description, $matches)) {
                                    $professor = trim($matches[1]); // Récupération du nom trouvé
                                }


                                $startDateTime = new DateTime($event->DTSTART->getValue(), new DateTimeZone('Europe/Paris'));
                                $endDateTime = new DateTime($event->DTEND->getValue(), new DateTimeZone('Europe/Paris'));

                                $startDateTime->modify('+1 hour');
                                $endDateTime->modify('+1 hour');

                                if ($startDateTime >= $startOfWeek && $startDateTime <= $endOfWeek) {
                                    $dateFormatted = $startDateTime->format('l');
                                    if (isset($daysMap[$dateFormatted])) {
                                        $eventsByDay[$daysMap[$dateFormatted]][] = [
                                            'summary' => $summary,
                                            'professor' => $professor,
                                            'location' => $location,
                                            'startTime' => $startDateTime,
                                            'endTime' => $endDateTime
                                        ];
                                    }
                                }
                            }

                            // Trier les événements par heure de début
                            foreach ($eventsByDay as &$events) {
                                usort($events, fn($a, $b) => $a['startTime'] <=> $b['startTime']);
                            }
                            ?>

                                <h2 style="text-align: center">Emploi du temps de la semaine</h2>
                                <div class="calendar">
                                    <?php foreach ($eventsByDay as $day => $events): ?>
                                        <div class="day">
                                            <strong><?= $day ?></strong>
                                            <?php foreach ($events as $event): ?>
                                                <div class="event">
                                                    <strong><?= htmlspecialchars($event['summary']) ?></strong><br>
                                                    <?= htmlspecialchars($event['professor']) ?><br> <!-- Affichage du prof -->
                                                    <?= htmlspecialchars($event['location']) ?><br> <!-- Affichage du lieu -->
                                                    (<?= $event['startTime']->format('H:i') ?> - <?= $event['endTime']->format('H:i') ?>)
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                    <?php
                            break;

                        case 'profile':
                            echo '<main>';
                            echo '<section class="profile">';
                            echo '<h1>Votre profil :</h1>';
                            echo '<h2>' . $_SESSION['name'] . '</h2>';

                            // Informations de profil
                            echo '<div class="profile-info">';
                            echo '<p><strong>Email:</strong> ' . $_SESSION['email'] . '</p>';
                            echo '<p><strong>Année:</strong> ' . $_SESSION['annee'] . '</p>';
                            echo '<p><strong>Groupe:</strong> ' . $_SESSION['groupe'] . '</p>';
                            echo '<!-- Popup -->
                    <div class="popup" id="popup">
                        <div id="message-container">
                            <p id="error-message" style="color: red; display: none;"></p>

                            <!-- Message de succès -->
                            <p id="success-message" style="color: green; display: none;"></p>
                        </div>

                        <form id="password-form"  method="post">
                            <input type="hidden" name="name" value="'.$_SESSION['name'] .'">

                            <label>Mot de passe actuel :</label>
                            <div class="password-container">
                                <input type="password" id="mdpActuel" name="mdpActuel" required>
                                <button type="button" class="toggle-password" data-target="mdpActuel">👁️</button>
                            </div>

                            <label>Nouveau mot de passe :</label>
                            <div class="password-container">
                                <input type="password" id="nouveauMdp1" name="nouveauMdp1" required>
                                <button type="button" class="toggle-password" data-target="nouveauMdp1">👁️</button>
                            </div>

                            <label>Confirmer le nouveau mot de passe :</label>
                            <div class="password-container">
                                <input type="password" id="nouveauMdp2" name="nouveauMdp2" required>
                                <button type="button" class="toggle-password" data-target="nouveauMdp2">👁️</button>
                            </div>

                            <button class="btn-save" type="submit">Enregistrer les modifications</button>
                            <button class="btn-close" onclick="closePopup()">Fermer</button>
                        </form>

                    </div>';
                            echo '<a href="#" onclick="openPopup(); return false;" class="profile-btn">Modifier mon <br> mot de passe</a>';
                            echo '<br>';
                            echo '<a href="/logout" class="profile-btn">Déconnexion</a>';


                            echo '</div>';

                            echo '</section>';
                            echo '</main>';

                            echo '</body>';
                            echo '</html>';
                            break;

                        default:
                            break;
                    }
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
        echo "<option value='titre'>titre</option>";
        echo "<option value='paragraphe'>paragraphe</option>";
        echo "<option value='list". $cpts['cpt']."'>liste d'article</option>";
        echo "<option value='lstlinked".$cpts['cpt2']."'>liste d'article avec lien</option>";
        echo "<option value='banderolle'>banderolle en haut de page</option>";
        echo "<option value='lien'>lien</option>";
        echo "<option value='img'>image</option>";
        echo "<option value='pdf'>PDF</option>";
        echo '</select>';
        echo '<input type="hidden" name="placement" value="' .$placement .'"/>';
        echo "<button type='submit' name='add'>Ajouter l'article</button></form></div></section><br>";
    }


    /**
     * Affiche la page.
     * @throws Exception
     */
    public function show(): void
    {
        ob_start();
        echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">';
        date_default_timezone_set('Europe/Paris');
        $page = $this->pageControlleur->genererTitre();
        $this->genererIntro();
        $this->genererArticles();

        (new Layout($page[0]['pagetitle'], ob_get_clean()))->show();

    }
}