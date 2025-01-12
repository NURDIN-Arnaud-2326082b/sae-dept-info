<?php

use PHPUnit\Framework\TestCase;
use App\src\views\pages\Layout;
use App\src\controllers\pages\NavbarController;
use App\src\views\pages\Footer;

class LayoutTest extends TestCase
{

    /**
     * Test de l'appel à la méthode de la barre de navigation (NavbarController).
     */
    public function testNavbarMethodIsCalled()
    {
        // Créer un mock de NavbarController
        $navbarMock = $this->createMock(NavbarController::class);
        $navbarMock->expects($this->once())  // Vérifier qu'il est appelé une seule fois
        ->method('defaultMethod');

        // Injecter le mock dans la classe Layout
        $layout = new Layout("Test Page", "<p>Content</p>");
        $reflection = new ReflectionClass(Layout::class);
        $navbarProperty = $reflection->getProperty('navbar');
        $navbarProperty->setValue($layout, $navbarMock);

        // Appeler la méthode show pour vérifier que le mock est utilisé
        $layout->show();
        ob_end_clean();
    }

    /**
     * Test de l'appel à la méthode du Footer.
     */
    public function testFooterMethodIsCalled()
    {
        // Créer un mock de Footer
        $footerMock = $this->createMock(Footer::class);
        $footerMock->expects($this->once())  // Vérifier qu'il est appelé une seule fois
        ->method('show');

        // Injecter le mock dans la classe Layout
        $layout = new Layout("Test Page", "<p>Content</p>");
        $reflection = new ReflectionClass(Layout::class);
        $footerProperty = $reflection->getProperty('footer');
        $footerProperty->setValue($layout, $footerMock);

        // Appeler la méthode show pour vérifier que le mock est utilisé
        ob_start();
        $layout->show();
        ob_end_clean();
    }

    /**
     * Méthode de nettoyage après chaque test pour éviter les tampons de sortie non fermés.
     */


}
