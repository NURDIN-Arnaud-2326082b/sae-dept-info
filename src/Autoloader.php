<?php

namespace App\src;

class Autoloader
{
    static function register(): void
    {
        spl_autoload_register([
            __CLASS__,
            'autoload'
        ]);
    }
    static function autoload($class): void
    {
        $class = str_replace(__NAMESPACE__ . '\\', '', $class);
        $class = str_replace('\\', '/', $class);
        if (file_exists(__DIR__ . '/' . $class . '.php')) {
            require __DIR__ . '/' . $class . '.php';
        }
    }
}