<?php
/**
 * Contrôleur StagiaireController – CRUD des stagiaires.
 */
class StagiaireController extends Controller
{
    private Stagiaire $model;

    public function __construct()
    {
        $this->model = new Stagiaire();
    }

    /** Liste tous les stagiaires. */
    public function index(): void
    {
        $stagiaires = $this->model->findAll();
        $this->render('stagiaires/index', [
            'stagiaires' => $stagiaires,
            'flash'      => $this->getFlash(),
        ]);
    }

    /** Affiche le formulaire de création. */
    public function create(): void
    {
        $this->render('stagiaires/form', [
            'stagiaire' => null,
            'action'    => 'store',
            'errors'    => [],
        ]);
    }

    /** Traite la soumission du formulaire de création. */
    public function store(): void
    {
        $data   = $this->getPostData();
        $errors = $this->validate($data);

        if (empty($errors) && !empty($data['email']) && $this->model->emailExists($data['email'])) {
            $errors['email'] = "Cet email est déjà utilisé par un autre stagiaire.";
        }

        if (!empty($errors)) {
            $this->render('stagiaires/form', [
                'stagiaire' => $data,
                'action'    => 'store',
                'errors'    => $errors,
            ]);
            return;
        }

        $this->model->create($data);
        $this->setFlash('success', "Stagiaire créé avec succès.");
        $this->redirect('index.php?controller=stagiaire&action=index');
    }

    /** Affiche le formulaire de modification. */
    public function edit(): void
    {
        $id        = (int) ($_GET['id'] ?? 0);
        $stagiaire = $this->model->findById($id);

        if (!$stagiaire) {
            $this->setFlash('error', "Stagiaire introuvable.");
            $this->redirect('index.php?controller=stagiaire&action=index');
            return;
        }

        $this->render('stagiaires/form', [
            'stagiaire' => $stagiaire,
            'action'    => 'update',
            'errors'    => [],
        ]);
    }

    /** Traite la soumission du formulaire de modification. */
    public function update(): void
    {
        $id   = (int) ($_POST['id'] ?? 0);
        $data = $this->getPostData();

        $errors = $this->validate($data);

        if (empty($errors) && !empty($data['email']) && $this->model->emailExists($data['email'], $id)) {
            $errors['email'] = "Cet email est déjà utilisé par un autre stagiaire.";
        }

        if (!empty($errors)) {
            $data['numero_stagiaire'] = $id;
            $this->render('stagiaires/form', [
                'stagiaire' => $data,
                'action'    => 'update',
                'errors'    => $errors,
            ]);
            return;
        }

        $this->model->update($id, $data);
        $this->setFlash('success', "Stagiaire mis à jour avec succès.");
        $this->redirect('index.php?controller=stagiaire&action=index');
    }

    /** Supprime un stagiaire. */
    public function delete(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        try {
            $this->model->delete($id);
            $this->setFlash('success', "Stagiaire supprimé.");
        } catch (Exception $e) {
            $this->setFlash('error', "Impossible de supprimer ce stagiaire : il possède des stages associés.");
        }
        $this->redirect('index.php?controller=stagiaire&action=index');
    }

    /** Affiche les détails d'un stagiaire et ses stages. */
    public function show(): void
    {
        $id        = (int) ($_GET['id'] ?? 0);
        $stagiaire = $this->model->findById($id);

        if (!$stagiaire) {
            $this->setFlash('error', "Stagiaire introuvable.");
            $this->redirect('index.php?controller=stagiaire&action=index');
            return;
        }

        $stages = $this->model->getStages($id);

        $this->render('stagiaires/show', [
            'stagiaire' => $stagiaire,
            'stages'    => $stages,
            'flash'     => $this->getFlash(),
        ]);
    }

    /** Extrait et nettoie les données du formulaire POST. */
    private function getPostData(): array
    {
        return [
            'nom'     => trim($_POST['nom']     ?? ''),
            'prenom'  => trim($_POST['prenom']  ?? ''),
            'email'   => trim($_POST['email']   ?? ''),
            'ecole'   => trim($_POST['ecole']   ?? ''),
            'filiere' => trim($_POST['filiere'] ?? ''),
        ];
    }

    /** Valide les données du stagiaire. Retourne un tableau d'erreurs. */
    private function validate(array $data): array
    {
        $errors = [];
        if (empty($data['nom']))    $errors['nom']    = "Le nom est obligatoire.";
        if (empty($data['prenom'])) $errors['prenom'] = "Le prénom est obligatoire.";
        if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "L'adresse email n'est pas valide.";
        }
        return $errors;
    }
}
