<?php
/**
 * Classe Controller – classe mère abstraite pour tous les contrôleurs.
 * Fournit le rendu des vues, les redirections et les messages flash.
 */
abstract class Controller
{
    /**
     * Inclut la vue avec ses données après avoir rendu l'en-tête et le pied de page.
     *
     * @param string $view  Chemin relatif de la vue sans l'extension (ex: 'stagiaires/index')
     * @param array  $data  Données transmises à la vue via extract()
     */
    protected function render(string $view, array $data = []): void
    {
        extract($data);
        $viewPath = APP . '/views/' . $view . '.php';

        if (!file_exists($viewPath)) {
            throw new RuntimeException("Vue introuvable : {$viewPath}");
        }

        require APP . '/views/layouts/header.php';
        require $viewPath;
        require APP . '/views/layouts/footer.php';
    }

    /**
     * Rend une vue sans le layout (utilisé pour l'impression / PDF).
     */
    protected function renderRaw(string $view, array $data = []): void
    {
        extract($data);
        $viewPath = APP . '/views/' . $view . '.php';

        if (!file_exists($viewPath)) {
            throw new RuntimeException("Vue introuvable : {$viewPath}");
        }

        require $viewPath;
    }

    /** Redirige vers une URL. */
    protected function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }

    /** Enregistre un message flash en session. */
    protected function setFlash(string $type, string $message): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
    }

    /** Récupère et supprime le message flash courant. */
    protected function getFlash(): ?array
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);
        return $flash;
    }
}
