<?php
/**
 * Autoloader — Chargement automatique des classes
 *
 * PHP appellera cette fonction quand une classe est utilisée
 * sans avoir été incluse manuellement.
 */

spl_autoload_register(function (string $className): void {
    $dirs = [
        ROOT_PATH . '/core/',
        ROOT_PATH . '/app/models/',
        ROOT_PATH . '/app/controllers/',
    ];

    foreach ($dirs as $dir) {
        $file = $dir . $className . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});
