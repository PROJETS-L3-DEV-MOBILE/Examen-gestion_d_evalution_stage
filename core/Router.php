<?php
/**
 * Classe Router — Routeur central de l'application
 *
 * Analyse l'URL et dispatch vers le bon contrôleur/action.
 * Format : ?controller=nom&action=methode&id=x
 */

class Router
{
    public static function dispatch(): void
    {
        $controllerName = $_GET['controller'] ?? 'home';
        $action         = $_GET['action']     ?? 'index';

        // Ex: 'stagiaire' → 'StagiaireController'
        $className = ucfirst($controllerName) . 'Controller';
        $filePath  = ROOT_PATH . '/app/controllers/' . $className . '.php';

        if (!file_exists($filePath)) {
            self::notFound("Contrôleur '$className' introuvable.");
            return;
        }

        require_once $filePath;

        if (!class_exists($className)) {
            self::notFound("Classe '$className' non définie.");
            return;
        }

        $controller = new $className();

        if (!method_exists($controller, $action)) {
            self::notFound("Action '$action' introuvable dans '$className'.");
            return;
        }

        $controller->$action();
    }

    private static function notFound(string $message): void
    {
        http_response_code(404);
        echo "<h1>404 — Page introuvable</h1><p>$message</p>";
        echo "<a href='" . BASE_URL . "'>Retour à l'accueil</a>";
    }
}
