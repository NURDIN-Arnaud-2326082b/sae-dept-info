<?php

namespace App\src\views;

class Footer {

    public function show(): void {
        ob_start();
        ?>
        <p>Footer</p>
        <?php
    }
}