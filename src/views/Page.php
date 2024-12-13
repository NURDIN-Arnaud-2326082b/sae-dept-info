<?php

namespace App\src\views;

use App\src\controllers\ConnexionController;
use App\src\controllers\PageControlleur;
use App\src\views\LayoutViews\Layout;


class Page
{
    private PageControlleur $pageControlleur;
    private ConnexionController $connexionController;

    /**
     * Constructeur de la classe Page.
     *
     * @param string $name Le nom de la page à afficher.
     * @param ConnexionController $connexionController Instance du contrôleur de connexion.
     */
    public function __construct(string $name, ConnexionController $connexionController)
    {
        $this->pageControlleur = new PageControlleur($name);
        $this->connexionController = $connexionController;
    }

    /**
     * Affiche la page.
     */
    public function show(): void
    {
        ob_start();

        // Générer le contenu de la page via PageControlleur
        $page = $this->pageControlleur->generer();
        echo $page[0]['content'];

        // Afficher le layout avec le titre et le contenu généré
        (new Layout($page[0]['title'], ob_get_clean()))->show();
    }
}
