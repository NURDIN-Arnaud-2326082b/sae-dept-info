<?php

use PHPUnit\Framework\TestCase;
use App\src\views\pages\Connexion;
use App\src\views\pages\Layout;

class ConnexionTest extends TestCase
{
    /**
     * Tester la méthode show de la classe Connexion pour vérifier si le HTML est généré correctement.
     */
    public function testShowGeneratesCorrectHtml()
    {
        // Créer une instance de la classe Connexion
        $connexionPage = new \App\src\views\pages\Connexion();

        // Appeler la méthode show() pour obtenir le HTML généré
        $htmlOutput = $connexionPage->show();

        // Vérifier si le lien vers la feuille de style 'Connexion.css' est présent
        $this->assertStringContainsString('<link rel="stylesheet" href="/assets/styles/Connexion.css">', $htmlOutput);

        // Vérifier si la structure principale de la page de connexion est présente
        $this->assertStringContainsString('<main>', $htmlOutput);
        $this->assertStringContainsString('<form action="/login" method="post">', $htmlOutput);
        $this->assertStringContainsString('<input type="submit" value="Se connecter">', $htmlOutput);
    }

    /**
     * Méthode de nettoyage après chaque test pour éviter les tampons de sortie non fermés.
     */
    protected function tearDown(): void
    {
        // Si un tampon est toujours ouvert, on le ferme.
        if (ob_get_level()) {
            ob_end_clean();
        }

        parent::tearDown();
    }
}
