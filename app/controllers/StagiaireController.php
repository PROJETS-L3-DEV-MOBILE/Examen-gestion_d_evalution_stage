<?php
/**
 * Contrôleur Stagiaire
 * Gère toutes les actions CRUD pour les stagiaires.
 */

class StagiaireController extends Controller
{
    private StagiaireModel $model;

    public function __construct()
    {
        $this->model = new StagiaireModel();
    }

    /**
     * Liste tous les stagiaires.
     */
    public function index(): void
    {
        $stagiaires = $this->model->getAll();
        $this->render('stagiaires/index', ['stagiaires' => $stagiaires], 'Stagiaires');
    }

    /**
     * Affiche le formulaire de création.
     */
    public function create(): void
    {
        $this->render('stagiaires/form', ['stagiaire' => null, 'errors' => []], 'Nouveau stagiaire');
    }

    /**
     * Traite la soumission du formulaire de création.
     */
    public function store(): void
    {
        $data   = $this->collectFormData();
        $errors = $this->validate($data);

        if (!empty($errors)) {
            // Re-affiche le formulaire avec les erreurs
            $this->render('stagiaires/form', [
                'stagiaire' => $data,
                'errors'    => $errors,
            ], 'Nouveau stagiaire');
            return;
        }

        $this->model->create($data);
        $this->redirect(BASE_URL . '?controller=stagiaire&action=index');
    }

    /**
     * Affiche le formulaire d'édition pour un stagiaire existant.
     */
    public function edit(): void
    {
        $id        = (int) $this->get('id');
        $stagiaire = $this->model->getById($id);

        if (!$stagiaire) {
            $this->redirect(BASE_URL . '?controller=stagiaire&action=index');
            return;
        }

        $this->render('stagiaires/form', [
            'stagiaire' => $stagiaire,
            'errors'    => [],
        ], 'Modifier le stagiaire');
    }

    /**
     * Traite la mise à jour d'un stagiaire.
     */
    public function update(): void
    {
        $id     = (int) $this->post('id');
        $data   = $this->collectFormData();
        $errors = $this->validate($data);

        if (!empty($errors)) {
            $data['numero_stagiaire'] = $id;
            $this->render('stagiaires/form', [
                'stagiaire' => $data,
                'errors'    => $errors,
            ], 'Modifier le stagiaire');
            return;
        }

        $this->model->update($id, $data);
        $this->redirect(BASE_URL . '?controller=stagiaire&action=index');
    }

    /**
     * Supprime un stagiaire (avec confirmation en GET pour sécurité).
     */
    public function delete(): void
    {
        $id = (int) $this->get('id');

        // Vérifie qu'une confirmation a été envoyée via POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->delete($id);
        }

        $this->redirect(BASE_URL . '?controller=stagiaire&action=index');
    }

    /**
     * Affiche le classement des stagiaires par note finale.
     */
    public function classement(): void
    {
        $classement = $this->model->getClassement();
        $this->render('stagiaires/classement', ['classement' => $classement], 'Classement');
    }

    // ─── Méthodes privées ───────────────────────────────────────────────────────

    /**
     * Collecte et nettoie les données du formulaire stagiaire.
     */
    private function collectFormData(): array
    {
        return [
            'nom'     => $this->post('nom', ''),
            'prenom'  => $this->post('prenom', ''),
            'email'   => $this->post('email', ''),
            'ecole'   => $this->post('ecole', ''),
            'filiere' => $this->post('filiere', ''),
        ];
    }

    /**
     * Valide les données du formulaire stagiaire.
     * Retourne un tableau d'erreurs (vide si tout est valide).
     */
    private function validate(array $data): array
    {
        $errors = [];

        if (empty($data['nom']))     $errors[] = "Le nom est obligatoire.";
        if (empty($data['prenom']))  $errors[] = "Le prénom est obligatoire.";
        if (empty($data['email']))   $errors[] = "L'email est obligatoire.";
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "L'adresse email n'est pas valide.";
        }
        if (empty($data['ecole']))   $errors[] = "L'école est obligatoire.";
        if (empty($data['filiere'])) $errors[] = "La filière est obligatoire.";

        return $errors;
    }
}