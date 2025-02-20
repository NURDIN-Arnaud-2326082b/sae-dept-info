<?php

namespace App\src\core;

/**
 * Autoloader Class
 *
 * Contient les méthodes pour l'autoload des classes.
 */
class Autoloader
{
    /**
     * S'enregistre en tant qu'autoload.
     */
    public static function register(): void
    {
        spl_autoload_register([
            __CLASS__,
            'autoload'
        ]);
    }

    /**
     * Autoload les classes.
     *
     * @param string $class La classe a autoloader.
     */
    public static function autoload($class): void
    {
        $class = str_replace(__NAMESPACE__ . '\\', '', $class);
        $class = str_replace('\\', '/', $class);
        if (file_exists(__DIR__ . '/' . $class . '.php')) {
            require __DIR__ . '/' . $class . '.php';
        }
    }
}