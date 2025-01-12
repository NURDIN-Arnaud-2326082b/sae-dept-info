<?php


use App\src\views\pages\Navbar;
use PHPUnit\Framework\TestCase;

class NavbarTest extends TestCase
{
    private Navbar $navbar;

    protected function setUp(): void
    {
        $this->navbar = new Navbar();
    }

    /**
     * Test de la méthode show avec un utilisateur connecté.
     */
    public function testShowWithAuthenticatedUser(): void
    {
        $user = [
            'name' => 'John Doe',
            'admin' => true
        ];

        ob_start();
        $this->navbar->show($user);
        $output = ob_get_clean();

        $this->assertStringContainsString('<h1>John Doe</h1>', $output);
        $this->assertStringContainsString('<a href="/logout" class="btn btn-logout">Se déconnecter</a>', $output);
        $this->assertStringContainsString('<a href="/gestion" class="btn btn-login">Gestion</a>', $output);
        $this->assertStringContainsString('<a href="#" onclick="openPopup(); return false;" class="btn btn-menu">Changer de<br> mot de passe</a>', $output);
    }

    /**
     * Test de la méthode show avec un utilisateur invité.
     */
    public function testShowWithGuestUser(): void
    {
        $user = [];

        ob_start();
        $this->navbar->show($user);
        $output = ob_get_clean();

        $this->assertStringContainsString('<h1>Invité</h1>', $output);
        $this->assertStringContainsString('<a href="/login" class="btn btn-login">Se connecter</a>', $output);
        $this->assertStringNotContainsString('<a href="/logout"', $output);
        $this->assertStringNotContainsString('<a href="/gestion"', $output);
    }

    /**
     * Test de la méthode show avec un utilisateur non administrateur.
     */
    public function testShowWithNonAdminUser(): void
    {
        $user = [
            'name' => 'Jane Doe',
        ];

        ob_start();
        $this->navbar->show($user);
        $output = ob_get_clean();

        $this->assertStringContainsString('<h1>Jane Doe</h1>', $output);
        $this->assertStringNotContainsString('<a href="/gestion"', $output);
        $this->assertStringContainsString('<a href="/logout" class="btn btn-logout">Se déconnecter</a>', $output);
    }
}

