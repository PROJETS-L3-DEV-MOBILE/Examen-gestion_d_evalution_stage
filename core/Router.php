<?php
/**
 * Classe Router – aiguille les requêtes vers le bon contrôleur et la bonne action.
 * La route est déterminée par les paramètres GET 'controller' et 'action'.
 */
class Router
{
    private array $controllerMap = [
        'home'        => 'HomeController',
        'stagiaire'   => 'StagiaireController',
        'entreprise'  => 'EntrepriseController',
        'critere'     => 'CritereController',
        'stage'       => 'StageController',
        'evaluation'  => 'EvaluationController',
    ];

    public function dispatch(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $controllerKey = strtolower(trim($_GET['controller'] ?? 'home'));
        $action        = preg_replace('/[^a-zA-Z0-9_]/', '', $_GET['action'] ?? 'index');

        // Repli sur la page d'accueil si le contrôleur est inconnu
        if (!isset($this->controllerMap[$controllerKey])) {
            $controllerKey = 'home';
            $action        = 'index';
        }

        $controllerClass = $this->controllerMap[$controllerKey];
        $controllerFile  = APP . '/controllers/' . $controllerClass . '.php';

        if (!file_exists($controllerFile)) {
            throw new RuntimeException("Contrôleur introuvable : {$controllerClass}");
        }

        // Chargement de tous les modèles
        foreach (glob(APP . '/models/*.php') as $modelFile) {
            require_once $modelFile;
        }

        require_once $controllerFile;

        $controller = new $controllerClass();

        if (!method_exists($controller, $action)) {
            throw new RuntimeException("Action introuvable : {$action} dans {$controllerClass}");
        }

        $controller->$action();
    }
}
