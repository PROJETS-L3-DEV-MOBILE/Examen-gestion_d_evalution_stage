<?php
/**
 * Classe Controller — Base pour tous les contrôleurs
 *
 * Fournit render(), redirect(), post(), get().
 */

abstract class Controller
{
    /**
     * Affiche une vue dans le layout principal.
     *
     * @param string $view  Chemin relatif depuis /app/views (ex: 'stagiaires/index')
     * @param array  $data  Variables injectées dans la vue
     * @param string $title Titre de la page
     */
    protected function render(string $view, array $data = [], string $title = APP_NAME): void
    {
        extract($data);

        $viewPath   = VIEWS_PATH . '/' . $view . '.php';
        $layoutPath = VIEWS_PATH . '/layouts/main.php';

        if (!file_exists($viewPath)) {
            die("Vue introuvable : $viewPath");
        }

        if (!file_exists($layoutPath)) {
            die("Layout introuvable : $layoutPath");
        }

        // Buffer la vue pour l'injecter dans le layout via $content
        ob_start();
        require $viewPath;
        $content = ob_get_clean();

        require $layoutPath;
    }

    protected function redirect(string $url): void
    {
        header("Location: $url");
        exit;
    }

    protected function post(string $key, mixed $default = null): mixed
    {
        return isset($_POST[$key]) ? trim($_POST[$key]) : $default;
    }

    protected function get(string $key, mixed $default = null): mixed
    {
        return isset($_GET[$key]) ? trim($_GET[$key]) : $default;
    }
}
