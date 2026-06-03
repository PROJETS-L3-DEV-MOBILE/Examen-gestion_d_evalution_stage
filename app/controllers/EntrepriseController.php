<?php
/**
 * Contrôleur EntrepriseController – CRUD des entreprises.
 */
class EntrepriseController extends Controller
{
    private Entreprise $model;

    public function __construct()
    {
        $this->model = new Entreprise();
    }

    public function index(): void
    {
        $entreprises = $this->model->findAll();
        $this->render('entreprises/index', [
            'entreprises' => $entreprises,
            'flash'       => $this->getFlash(),
        ]);
    }

    public function create(): void
    {
        $this->render('entreprises/form', [
            'entreprise' => null,
            'action'     => 'store',
            'errors'     => [],
        ]);
    }

    public function store(): void
    {
        $data   = $this->getPostData();
        $errors = $this->validate($data);

        if (!empty($errors)) {
            $this->render('entreprises/form', [
                'entreprise' => $data,
                'action'     => 'store',
                'errors'     => $errors,
            ]);
            return;
        }

        $this->model->create($data);
        $this->setFlash('success', "Entreprise créée avec succès.");
        $this->redirect('index.php?controller=entreprise&action=index');
    }

    public function edit(): void
    {
        $id         = (int) ($_GET['id'] ?? 0);
        $entreprise = $this->model->findById($id);

        if (!$entreprise) {
            $this->setFlash('error', "Entreprise introuvable.");
            $this->redirect('index.php?controller=entreprise&action=index');
            return;
        }

        $this->render('entreprises/form', [
            'entreprise' => $entreprise,
            'action'     => 'update',
            'errors'     => [],
        ]);
    }

    public function update(): void
    {
        $id     = (int) ($_POST['id'] ?? 0);
        $data   = $this->getPostData();
        $errors = $this->validate($data);

        if (!empty($errors)) {
            $data['numero_entreprise'] = $id;
            $this->render('entreprises/form', [
                'entreprise' => $data,
                'action'     => 'update',
                'errors'     => $errors,
            ]);
            return;
        }

        $this->model->update($id, $data);
        $this->setFlash('success', "Entreprise mise à jour avec succès.");
        $this->redirect('index.php?controller=entreprise&action=index');
    }

    public function delete(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        try {
            $this->model->delete($id);
            $this->setFlash('success', "Entreprise supprimée.");
        } catch (Exception $e) {
            $this->setFlash('error', "Impossible de supprimer cette entreprise : des stages y sont associés.");
        }
        $this->redirect('index.php?controller=entreprise&action=index');
    }

    private function getPostData(): array
    {
        return [
            'nom'              => trim($_POST['nom']              ?? ''),
            'secteur_activite' => trim($_POST['secteur_activite'] ?? ''),
            'ville'            => trim($_POST['ville']            ?? ''),
        ];
    }

    private function validate(array $data): array
    {
        $errors = [];
        if (empty($data['nom'])) $errors['nom'] = "Le nom de l'entreprise est obligatoire.";
        return $errors;
    }
}
