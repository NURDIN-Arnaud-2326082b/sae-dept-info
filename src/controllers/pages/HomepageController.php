<?php

namespace App\src\controllers\pages;

use App\src\database\DatabaseConnection;
use App\src\models\HomepageModel;
use App\src\views\HomepageViews\Homepage;

class HomepageController
{
    /**
     * Constructeur de la classe.
     */
    public function __construct()
    {

    }

    /**
     * Constructeur de la classe.
     */
    public function defaultMethod(): void
    {
        (new homepage())->show();
    }

    /**
     * @throws \Exception
     */
    public function updateArticleAction(): void
    {
        $id = $_POST['id'];
        $titre = $_POST['titre'];
        $contenu = $_POST['contenu'];
        $model = new HomepageModel(DatabaseConnection::getInstance());
        $model->updateArticleAction($id,$titre, $contenu);
    }

    public function genererBanderole(){
        $model = new HomepageModel(DatabaseConnection::getInstance());
        $tab = $model->genererArticle(1);
        echo "<form method='POST' action='/homepage/updateArticle'>"
            . "<input type='hidden' name='id' value='1' />"
            . "<input type='text' value='".$tab[0]['Title']."' style='font-size: 1.5rem; font-weight: bold; width: 100%; border: none; background: transparent;' name='titre'/>"
            . "<button type='submit'>Enregistrer les modifications</button>"
            . "</form>";
    }
    public function generer(): void
    {
        $model = new HomepageModel(DatabaseConnection::getInstance());
        $tab = $model->recupTable();
        foreach ($tab as $article){
            if ($article[0]['Id_Article'] == 1){
                continue;
            }
            else{
                echo '<div class="article-preview">'. '<div class="article-content">'. "<form method='POST' action='/homepage/updateArticle'>"
                    . "<input type='hidden' name='id' value='".$article[0]['Id_Article']."' />"
                    . "<input type='text' value='".$article[0]['Title']."' style='font-size: 1.5rem; font-weight: bold; width: 100%; border: none; background: transparent;' name='titre'/>"
                    . "<textarea rows='3' cols='50' style='font-size: 1.25rem; width: 100%; border: none; background: transparent;' name='contenu'>".$article[0]['Content']."</textarea>"
                    .'<a href="'.$article[0]["Link"].'" class="read-more">En savoir plus</a>'
                    . "<button type='submit'>Enregistrer les modifications</button>"
                    . '</form>'
                    .'</div>'
                    . "<img src='/assets/images/formation.png' alt='Illustration de léco-ambassadeur' class='article-image'>"
                    . '</div>';
            }

        }
    }
}