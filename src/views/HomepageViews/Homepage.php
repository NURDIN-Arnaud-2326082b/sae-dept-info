<?php
namespace App\src\views\HomepageViews;

use App\src\controllers\pages\HomepageController;
use App\src\views\LayoutViews\Layout;
class Homepage {
    public function show(): void {
        ob_start();
        $controller = new HomepageController();
        require_once "src/views/HomepageViews/fragments/partie1.php";
        $controller->genererBanderole();
        require_once "src/views/HomepageViews/fragments/partie2.php";
        $controller->generer();
        ?>
</div>
        </main>
        <?php
        (new Layout('Accueil', ob_get_clean()))->show();
    }
}