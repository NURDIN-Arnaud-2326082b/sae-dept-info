<?php
namespace App\src\controllers\pages;

use App\src\database\DatabaseConnection;
use App\src\views\AlumniViews\Alumni;
use App\src\views\PresentationFormationViews\PresentationFormation;

class AlumniController
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
     * Affiche la page des alumnis.
     *
     */
    public function defaultMethod(): void
    {
        (new Alumni())->show();
    }
}
