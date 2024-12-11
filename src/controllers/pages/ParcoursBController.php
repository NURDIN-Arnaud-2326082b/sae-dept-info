<?php
namespace App\src\controllers\pages;

use App\src\database\DatabaseConnection;
use App\src\views\AlumniViews\Alumni;
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
     * Affiche la page de presentation du parcours B.
     *
     */
    public function defaultMethod(): void
    {
        (new ParcoursB())->show();
    }
}
