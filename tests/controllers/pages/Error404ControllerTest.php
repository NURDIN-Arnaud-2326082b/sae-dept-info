<?php

use PHPUnit\Framework\TestCase;
use App\src\controllers\pages\Error404Controller;
use App\src\views\pages\Error404;

class Error404ControllerTest extends TestCase
{
    private $error404Controller;

    /**
     * Configurer le test.
     */
    protected function setUp(): void
    {
        // Créer un mock pour la vue Error404
        $error404Mock = $this->createMock(Error404::class);
        // Créer une instance de Error404Controller
        $this->error404Controller = new Error404Controller($error404Mock);
    }

    /**
     * Tester la méthode defaultMethod pour vérifier si show() est appelée.
     */
    public function testDefaultMethodCallsShow(): void
    {
        // Créer un mock pour la vue Error404
        $error404Mock = $this->createMock(Error404::class);

        // Vérifier que la méthode show est appelée une fois
        $error404Mock->expects($this->once())
            ->method('show');

        // Créer une instance du contrôleur en injectant le mock
        $this->error404Controller = new Error404Controller($error404Mock);

        // Appeler la méthode à tester
        $this->error404Controller->defaultMethod();
    }

}
