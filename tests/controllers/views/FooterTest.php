<?php

use PHPUnit\Framework\TestCase;
use App\src\views\pages\Footer;

class FooterTest extends TestCase
{
    /**
     * Test de la méthode show() pour vérifier la génération du footer HTML.
     */
    public function testShow()
    {
        // Capture de la sortie de la méthode show()
        ob_start(); // Commence à capturer la sortie
        $footer = new Footer();
        $footer->show();
        $output = ob_get_clean(); // Récupère la sortie capturée

        // Vérifiez que le contenu généré contient certains éléments spécifiques
        $this->assertStringContainsString('<footer class="footer">', $output);
        $this->assertStringContainsString('<a href="/">', $output);
        $this->assertStringContainsString('<img src="/assets/images/logo_amu.png" alt="logo iut">', $output);
        $this->assertStringContainsString('© 2024 Département Informatique - IUT d\'Aix-Marseille', $output);
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
