<?php

use PHPUnit\Framework\TestCase;
use App\src\views\pages\Error404;

class Error404Test extends TestCase
{
    /**
     * Test de la méthode show() pour vérifier la génération du contenu HTML.
     */
    public function testShow()
    {
        // Capture de la sortie de la méthode show()
        ob_start(); // Commence à capturer la sortie
        $errorPage = new Error404();
        $errorPage->show();
        $output = ob_get_clean(); // Récupère la sortie capturée

        // Vérifiez que le contenu généré contient certains éléments spécifiques
        $this->assertStringContainsString('<title>Error 404</title>', $output);
        $this->assertStringContainsString('404, page not found.', $output);
        $this->assertStringContainsString('<meta charset="utf-8">', $output);
        $this->assertStringContainsString('<meta name="viewport" content="width=device-width, initial-scale=1">', $output);
        $this->assertStringContainsString('<link rel="icon" type="image/png" href="" sizes="32x32" />', $output);
    }
}
