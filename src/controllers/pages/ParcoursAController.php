<?php
namespace App\src\controllers\pages;

use App\src\database\DatabaseConnection;
use App\src\views\ParcoursAViews\ParcoursA;

class ParcoursAController
{
    /**
     * Constructeur de la classe.
     */
    public function __construct()
    {
        $database = DatabaseConnection::getInstance();
        $db = $database->getConnection();
    }

    /**
     * Affiche la page de presentation du parcours A.
     *
     */
    public function defaultMethod(): void
    {
        (new ParcoursA())->show();
    }
}
