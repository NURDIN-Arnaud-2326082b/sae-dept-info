<?php

namespace App\src\controllers\pages;

use App\src\views\PlanningViews\Planning;

class PlanningController
{

    public function defaultMethod($icsContent): void
    {
        (new Planning())->show($icsContent);

    }

    public function planning(): void
    {
        $icalUrl = 'https://ade-web-consult.univ-amu.fr/jsp/custom/modules/plannings/anonymous_cal.jsp?projectId=8&resources=6432&calType=ical&firstDate=2025-07-07&lastDate=2025-07-11';
        $icsContent = file_get_contents($icalUrl);

        if ($icsContent === false) {
            echo "<p>Erreur : Impossible de récupérer le contenu du fichier iCal.</p>";
            return; // Sortir de la méthode si la récupération échoue
        }

        (new Planning())->show($icsContent);

    }

}