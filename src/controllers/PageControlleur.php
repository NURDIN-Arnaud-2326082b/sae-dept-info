<?php

namespace App\src\controllers;
use App\src\database\DatabaseConnection;
use App\src\models\PageModel;
use App\src\views\Page;

class PageControlleur
{
    private string $name;
    private PageModel $pageModel;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->pageModel = new PageModel(DatabaseConnection::getInstance());
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
        echo '<link rel="stylesheet" href="/assets/styles/page.css"><main>';
        if (isset($_SESSION['admin']) && $_SESSION['admin']) {
            foreach ($content as $ct) {
                switch ($ct['type']) {
                    case 'banderolle':
                        echo '<div class="marquee"><form action="/PageControlleur/updateArticle" method="post"><input type="hidden" name="name" value="'.$this->name.'"/>';
                        echo '<input type="hidden" name="id" value="'.$ct['id_article'].'" /><input type="text" value="'.$ct['title'].'" style="font-size: 2.5rem; font-weight: bold; text-align: center; width: 100%; border: none; background: transparent;" name="titre"/>';
                        echo '<button type="submit">Enregistrer les modifications</button></form>';
                        echo "<form action='/PageControlleur/deleteArticle' method='POST'><input type='hidden' name='action' value='delete'><input type='hidden' name='name' value='".$this->name."'/><button type='submit' name='delete' value='". $ct['id_article'] . "'>Supprimer l'article'</button></form></div>";
                        break;
                    case 'intro':
                        echo ' <section class="hero-section"><div class="hero-content"><form action="/PageControlleur/updateArticle" method="post"><input type="hidden" name="name" value="'.$this->name.'"/>';
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
        if (isset($_SESSION['admin'])) {
            if ($this->getName() == 'Homepage') {
                echo '  <div class="articles-grid">';
                foreach ($content as $ct) {
                    if ($ct['type'] == 'homepage') {
                        echo '<div class="article-preview"><div class="article-content"><form action="/PageControlleur/updateArticle" method="post"><input type="hidden" name="name" value="'.$this->name.'"/>';
                        echo '<input type="hidden" name="id" value="'.$ct['id_article'].'"/><input type="text" value="'.$ct['title'].'" style="font-size: 2.5rem; font-weight: bold; text-align: center; width: 100%; border: none; background: transparent;" name="titre"/>';
                        echo '<textarea rows="3" cols="50" style="font-size: 1.25rem; width: 100%; text-align: center; border: none; background: transparent;" name="contenu">'. $ct['content'] .'</textarea>';
                        echo '<a href="' . $ct['link'] . '" class="read-more">En savoir plus</a>';
                        echo "<button type='submit'>Enregistrer les modifications</button></form><form action='/PageControlleur/deleteArticle' method='POST'><input type='hidden' name='action' value='delete'><input type='hidden' name='name' value='".$this->name."'/><button type='submit' name='delete' value='". $ct['id_article'] . "'>Supprimer l'article</button></form></div>' . '<img src='/assets/images/formation.png' alt='Illustration de léco-ambassadeur' class='article-image'>";
                        echo '</div>';
                    }
                }
                echo "<form action='/PageControlleur/ajouterArticle' method='post'><input type='hidden' name='name' value='".$this->name."'/><input type='hidden' name='type' value='homepage'/><button type='submit' name='add'>Ajouter un article</button></form>";
                echo '</div>';
            } elseif ($this->getName() == 'menu') {
                echo '<div class="panel-container">';
                foreach ($content as $ct) {
                    if ($ct['type'] == 'menu') {
                        echo '<div class="panel" onclick="window.location.href=\'' . $ct['link'] . '\';"><form action="/PageControlleur/updateArticle" method="post"><input type="hidden" name="name" value="'.$this->name.'"/><input type="hidden" name="id" value="'.$ct['id_article'].'"/>';
                        echo '<textarea rows="3" cols="50" style="font-size: 1.25rem; width: 100%; text-align: center; border: none; background: transparent;" name="contenu">'. $ct['title'] .'</textarea>';
                        echo '<button type="submit">Enregistrer les modifications</button></form>';
                        echo "<form action='/PageControlleur/deleteArticle' method='POST'><input type='hidden' name='action' value='delete'><input type='hidden' name='name' value='".$this->name."'/><button type='submit' name='delete' value='". $ct['id_article'] . "'>Supprimer l'article</button></form>";
                        echo '</div>';
                    }
                }
                echo "<form action='/PageControlleur/ajouterArticle' method='post'><input type='hidden' name='name' value='".$this->name."'/><input type='hidden' name='type' value='menu'/><button type='submit' name='add'>Ajouter un article</button></form>";
                echo '</div>';
            }
            if ($content[0] != null) {
                echo '<section id="content" class="department-content">';
            }
            $cpt = 1;
            foreach ($content as $ct) {
                switch ($ct['type']) {
                    case 'texte':
                        echo '<div class="intro"><form action="/PageControlleur/updateArticle" method="post"><input type="hidden" name="name" value="'.$this->name.'"/>';
                        echo '<input type="hidden" name="id" value="'.$ct['id_article'].'" /><input type="text" value="'.$ct['title'].'" style="font-size: 2.5rem; font-weight: bold; text-align: center; width: 100%; border: none; background: transparent;" name="titre"/>';
                        echo '<textarea rows="3" cols="50" style="font-size: 1.25rem; width: 100%; text-align: center; border: none; background: transparent;" name="contenu">'. $ct['content'] .'</textarea>';
                        echo '<button type="submit">Enregistrer les modifications</button></form>';
                        echo "<form action='/PageControlleur/deleteArticle' method='POST'><input type='hidden' name='action' value='delete'><input type='hidden' name='name' value='".$this->name."'/><button type='submit' name='delete' value='". $ct['id_article'] . "'>Supprimer l'article'</button></form>";
                        echo '</div>';
                        break;
                    case 'list' . $cpt:
                        $cpt2 = 0;
                        echo '<div class="features-grid">';
                        foreach ($content as $ct2) {
                            if ($ct2['type'] == 'list' . $cpt) {
                                echo '<div class="feature"><form action="/PageControlleur/updateArticle" method="post"><input type="hidden" name="name" value="'.$this->name.'"/>';
                                echo '<img src="/assets/images/img.png" alt="Innovation">';
                                echo '<input type="hidden" name="id" value="'.$ct2['id_article'].'"/><input type="text" value="'.$ct2['title'].'" style="font-size: 2.5rem; font-weight: bold; text-align: center; width: 100%; border: none; background: transparent;" name="titre"/>';
                                echo '<textarea rows="3" cols="50" style="font-size: 1.25rem; width: 100%; text-align: center; border: none; background: transparent;" name="contenu">'. $ct2['content'] .'</textarea>';
                                echo '<button type="submit">Enregistrer les modifications</button></form>';
                                echo "<form action='/PageControlleur/deleteArticle' method='POST'><input type='hidden' name='action' value='delete'><input type='hidden' name='name' value='".$this->name."'/><button type='submit' name='delete' value='". $ct['id_article'] . "'>Supprimer l'article'</button></form>";
                                echo '</div>';
                                $cpt2++;
                            }
                        }
                        for ($i = 0; $i < $cpt2; $i++) {
                            array_shift($content);
                        }
                        $type = $ct['type'];
                        echo '<form action="/PageControlleur/ajouterArticle" method="post"><input type="hidden" name="name" value="'.$this->name.'"/><input type="hidden" name="type" value="'.$type.'"/><button type="submit" name="add">Ajouter un article</button></form>';
                        echo '</div>';
                        $cpt++;
                        break;
                    case 'titre':
                        echo '<form action="/PageControlleur/updateArticle" method="post"><input type="hidden" name="name" value="'.$this->name.'"/><input type="hidden" name="id" value="'.$ct['id_article'].'"/><input type="text" value="'.$ct['title'].'" style="font-size: 2.5rem; font-weight: bold; text-align: center; width: 100%; border: none; background: transparent;" name="titre"/><button type="submit">Enregistrer les modifications</button></form>';
                        echo "<form action='/PageControlleur/deleteArticle' method='POST'><input type='hidden' name='action' value='delete'><input type='hidden' name='name' value='".$this->name."'/><button type='submit' name='delete' value='". $ct['id_article'] . "'>Supprimer l'article'</button></form>";
                        break;
                    case 'lien':
                        echo '<div><form action="/PageControlleur/updateArticle" method="post"><input type="hidden" name="name" value="'.$this->name.'"/><input type="hidden" name="id" value="'.$ct['id_article'].'"/><textarea rows="3" cols="50" style="font-size: 1.25rem; width: 100%; text-align: center; border: none; background: transparent;" name="lien">'. $ct['link'] .'</textarea><textarea rows="3" cols="50" style="font-size: 1.25rem; width: 100%; text-align: center; border: none; background: transparent;" name="contenu">'. $ct['content'] .'</textarea><button type="submit">Enregistrer les modifications</button></form>';
                        echo "<form action='/PageControlleur/deleteArticle' method='POST'><input type='hidden' name='action' value='delete'><input type='hidden' name='name' value='".$this->name."'/><button type='submit' name='delete' value='". $ct['id_article'] . "'>Supprimer l'article'</button></form>";
                        echo '</div>';
                        break;
                    case 'paragraphe':
                        echo '<div><form action="/PageControlleur/updateArticle" method="post"><input type="hidden" name="name" value="'.$this->name.'"/><input type="hidden" name="id" value="'.$ct['id_article'].'"/><textarea rows="3" cols="50" style="font-size: 1.25rem; width: 100%; text-align: center; border: none; background: transparent;" name="contenu">'. $ct['content'] .'</textarea><button type="submit">Enregistrer les modifications</button></form>';
                        echo "<form action='/PageControlleur/deleteArticle' method='POST'><input type='hidden' name='action' value='delete'><input type='hidden' name='name' value='".$this->name."'/><button type='submit' name='delete' value='". $ct['id_article'] . "'>Supprimer l'article'</button></form>";
                        echo '</div>';
                        break;
                    case 'img':
                        echo '<div>';
                        echo '<img src="/PageControlleur/getImage?id='.$ct['id_article'].'" alt="'.$ct['title'].'">';
                        echo '<form action="/PageControlleur/updateImage" method="post" enctype="multipart/form-data">';
                        echo '<input type="hidden" name="id" value="'.$ct['id_article'].'">';
                        echo '<label for="file-'.$ct['id_article'].'" class="dropzone">Glissez & déposez une image ou cliquez ici</label>';
                        echo '<input type="file" id="file-'.$ct['id_article'].'" name="image" accept="image/*" onchange="this.form.submit()" style="display: none;">';
                        echo '<input type="hidden" name="name" value="'.$this->name.'"/>';
                        echo '</form>';
                        echo "<form action='/PageControlleur/deleteArticle' method='POST'><input type='hidden' name='action' value='delete'><input type='hidden' name='name' value='".$this->name."'/><button type='submit' name='delete' value='". $ct['id_article'] . "'>Supprimer l'article'</button></form>";
                        echo '</div>';
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
                        echo '<div class="article-preview">';
                        echo '<img src="/PageControlleur/getImage?id=' . $ct['id_article'] . '" alt="' . htmlspecialchars($ct['title'], ENT_QUOTES) . '" class="article-image">';
                        echo '<div class="article-content">';
                        echo '<h3>' . $ct['title'] . '</h3>';
                        echo '<p>' . $ct['content'] . '</p>';
                        echo '<a href="' . $ct['link'] . '" class="read-more">En savoir plus</a>';
                        echo '</div>'; // Fin de article-content
                        echo '</div>'; // Fin de article-preview
                    }
                }
                echo '</div>'; // Fin de articles-grid
            }
            elseif ($this->getName() == 'menu') {
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
                                echo '<img src="/PageControlleur/getImage?id='.$ct['id_article'].'" alt="'.$ct['title'].'">';
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
        if($lien == null){
            $lien = '';
        }
        if ($contenu == null){
            $contenu = '';
        }
        if ($titre == null){
            $titre = '';
        }
        $this->pageModel->updateArticleAction($id,$titre, $contenu,$lien);
        header('Location: /'.$_POST['name']);
    }

    public function deleteArticleAction(): void
    {
        $id = $_POST['delete'];
        $this->pageModel->deleteArticleAction($id);
        header('Location: /'.$_POST['name']);
    }

    /**
     * @throws \Exception
     */
    public function ajouterArticleAction(): void
    {
        $type = $_POST['type'];
        if ($type === 'img' && isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $fileType = mime_content_type($_FILES['image']['tmp_name']);
            $fileData = file_get_contents($_FILES['image']['tmp_name']);
            // Ajoutez une méthode spécifique pour enregistrer l'image
            $this->pageModel->ajouterImage($fileType, $fileData, $_POST['name']);
        }
        elseif ($type == 'menu'){
            $this->pageModel->ajouterPage('Menu','menu');
        }
        elseif ($type == 'homepage'){
            $this->pageModel->ajouterPage('Homepage','homepage');

        }
        else {
            $this->pageModel->ajouterArticleAction($type, $_POST['name'],null);
        }
        header('Location: /'.$_POST['name']);
    }


    public function genererNewArticle(): void
    {
        $type = $this->pageModel->recupererType();
        $cpt = 0 ;
        foreach ($type as $t){
            if(str_contains($t['type'],"list")){
                $cpt++;
            }
        }
       echo '<section id="content" class="department-content"><div><form action="/PageControlleur/ajouterArticle" method="post"  enctype="multipart/form-data"><input type="hidden" name="name" value="'.$this->name.'"/>';
       echo '<h2>Ajouter un article</h2>';
       echo '<select name="type" id="article-type" onchange="toggleImageUpload(this.value)">';
         echo '<option value="texte">texte avec titre</option>';
         echo "<option value='list".$cpt."'>liste d'article</option>";
         echo "<option value='banderolle'>banderolle en haut de page</option>";
            echo "<option value='lien'>lien</option>";
            echo "<option value='titre'>titre</option>";
            echo "<option value='paragraphe'>paragraphe</option>";
            echo "<option value='img'>image</option>";
            echo '</select>';
        echo '<div id="image-upload" style="display: none; margin-top: 10px;">';
        echo '<label for="image">Choisir une image :</label>';
        echo '<input type="file" name="image" id="image" accept="image/*">';
        echo '</div>';
         echo "<button type='submit' name='add'>Ajouter l'article</button></form></div></section>";
    }

    public function getImage(): void
    {
        $id = $_GET['id'];
        $imageData = $this->pageModel->getImageById($id);

        if ($imageData) {
            header("Content-Type: " . $imageData['type']);
            echo $imageData['image'];
        } else {
            http_response_code(404);
            echo "Image non trouvée.";
        }
    }

    public function updateImageAction(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $id = $_POST['id'] ?? null;
            $name = $_POST['name'] ?? null;
            $fileType = mime_content_type($_FILES['image']['tmp_name']);
            $fileData = file_get_contents($_FILES['image']['tmp_name']);

            $this->pageModel->updateImageById($id, $fileType, $fileData);

            header('Location: /' . $name);
        }
    }

}

