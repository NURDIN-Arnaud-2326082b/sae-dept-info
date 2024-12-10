<?php
namespace App\src\controllers\pages;

use App\src\database\DatabaseConnection;
use App\src\views\ParcoursBViews\ParcoursB;

class ParcoursBController
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
     * Affiche la page de presentation de la formation et des parcours (A et B).
     *
     */
    public function defaultMethod(): void
    {
        (new ParcoursB())->show();
    }
}
