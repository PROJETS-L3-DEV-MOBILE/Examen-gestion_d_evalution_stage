<?php
/**
 * Contrôleur parent - classe abstraite pour tous les contrôleurs.
 * Fournit le rendu des vues, les redirections, les messages flash et la validation.
 */
abstract class Controller
{
    /**
     * Inclut la vue avec ses données et le layout.
     *
     * @param string $view  Chemin de la vue sans extension (ex: 'stagiaires/index')
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
     * Rend une vue sans layout (impression, PDF, ajax).
     *
     * @param string $view  Chemin de la vue sans extension
     * @param array  $data  Données transmises à la vue
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

    /**
     * Redirige vers une URL.
     *
     * @param string $url URL de redirection
     */
    protected function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }

    /**
     * Enregistre un message flash en session.
     *
     * @param string $type    Type du message ('success', 'error', etc.)
     * @param string $message Message à afficher
     */
    protected function setFlash(string $type, string $message): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
    }

    /**
     * Récupère et supprime le message flash de la session.
     *
     * @return array|null Le message flash ou null
     */
    protected function getFlash(): ?array
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);
        return $flash;
    }

    /**
     * Récupère et nettoie les données POST.
     *
     * @return array Données POST trimées
     */
    protected function getPostData(): array
    {
        $data = [];
        foreach ($_POST as $key => $value) {
            $data[$key] = is_string($value) ? trim($value) : $value;
        }
        return $data;
    }

    /**
     * Valide les données génériques (nom, prénom, email).
     * À surcharger dans les contrôleurs pour une validation spécifique.
     *
     * @param array $data Données à valider
     * @return array Tableau d'erreurs
     */
    protected function validate(array $data): array
    {
        $errors = [];

        // Validation du nom si présent
        if (isset($data['nom']) && empty($data['nom'])) {
            $errors['nom'] = "Le nom est obligatoire.";
        }

        // Validation du prénom si présent
        if (isset($data['prenom']) && empty($data['prenom'])) {
            $errors['prenom'] = "Le prénom est obligatoire.";
        }

        // Validation de l'email si présent
        if (isset($data['email']) && !empty($data['email'])) {
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "L'adresse email n'est pas valide.";
            }
        }

        // Validation du libellé si présent
        if (isset($data['libelle_critere']) && empty($data['libelle_critere'])) {
            $errors['libelle_critere'] = "Le libellé est obligatoire.";
        }

        // Validation du coefficient si présent
        if (isset($data['coefficient'])) {
            if (!is_numeric($data['coefficient'])) {
                $errors['coefficient'] = "Le coefficient doit être un nombre.";
            } elseif ((float) $data['coefficient'] < 0) {
                $errors['coefficient'] = "Le coefficient ne peut pas être négatif.";
            }
        }

        // Validation du sujet si présent
        if (isset($data['sujet']) && empty($data['sujet'])) {
            $errors['sujet'] = "Le sujet est obligatoire.";
        }

        // Validation des dates si présentes
        if (isset($data['dateDebut']) && isset($data['dateFin'])) {
            if (empty($data['dateDebut'])) {
                $errors['dateDebut'] = "La date de début est obligatoire.";
            } elseif (empty($data['dateFin'])) {
                $errors['dateFin'] = "La date de fin est obligatoire.";
            } elseif (strtotime($data['dateDebut']) >= strtotime($data['dateFin'])) {
                $errors['dates'] = "La date de début doit être antérieure à la date de fin.";
            }
        }

        return $errors;
    }
}
