<?php
/**
 * Contrôleur CritereController – CRUD des critères d'évaluation.
 */
class CritereController extends Controller
{
    private CritereEvaluation $model;

    public function __construct()
    {
        $this->model = new CritereEvaluation();
    }

    public function index(): void
    {
        $criteres = $this->model->findAll();
        $this->render('criteres/index', [
            'criteres' => $criteres,
            'flash'    => $this->getFlash(),
        ]);
    }

    public function create(): void
    {
        $this->render('criteres/form', [
            'critere' => null,
            'action'  => 'store',
            'errors'  => [],
        ]);
    }

    public function store(): void
    {
        $data   = $this->getPostData();
        $errors = $this->validate($data);

        if (!empty($errors)) {
            $this->render('criteres/form', [
                'critere' => $data,
                'action'  => 'store',
                'errors'  => $errors,
            ]);
            return;
        }

        try {
            $this->model->create($data);
            $this->setFlash('success', "Critère créé avec succès.");
            $this->redirect('index.php?controller=critere&action=index');
        } catch (InvalidArgumentException $e) {
            $errors['coefficient'] = $e->getMessage();
            $this->render('criteres/form', [
                'critere' => $data,
                'action'  => 'store',
                'errors'  => $errors,
            ]);
        }
    }

    public function edit(): void
    {
        $id      = (int) ($_GET['id'] ?? 0);
        $critere = $this->model->findById($id);

        if (!$critere) {
            $this->setFlash('error', "Critère introuvable.");
            $this->redirect('index.php?controller=critere&action=index');
            return;
        }

        $this->render('criteres/form', [
            'critere' => $critere,
            'action'  => 'update',
            'errors'  => [],
        ]);
    }

    public function update(): void
    {
        $id     = (int) ($_POST['id'] ?? 0);
        $data   = $this->getPostData();
        $errors = $this->validate($data);

        if (!empty($errors)) {
            $data['id_critere'] = $id;
            $this->render('criteres/form', [
                'critere' => $data,
                'action'  => 'update',
                'errors'  => $errors,
            ]);
            return;
        }

        try {
            $this->model->update($id, $data);
            $this->setFlash('success', "Critère mis à jour avec succès.");
            $this->redirect('index.php?controller=critere&action=index');
        } catch (InvalidArgumentException $e) {
            $errors['coefficient'] = $e->getMessage();
            $data['id_critere']    = $id;
            $this->render('criteres/form', [
                'critere' => $data,
                'action'  => 'update',
                'errors'  => $errors,
            ]);
        }
    }

    public function delete(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        try {
            $this->model->delete($id);
            $this->setFlash('success', "Critère supprimé.");
        } catch (Exception $e) {
            $this->setFlash('error', "Impossible de supprimer ce critère : des évaluations y font référence.");
        }
        $this->redirect('index.php?controller=critere&action=index');
    }

    protected function getPostData(): array
    {
        return [
            'libelle_critere' => trim($_POST['libelle_critere'] ?? ''),
            'coefficient'     => $_POST['coefficient'] ?? '0',
        ];
    }

    protected function validate(array $data): array
    {
        $errors = [];
        if (empty($data['libelle_critere'])) {
            $errors['libelle_critere'] = "Le libellé du critère est obligatoire.";
        }
        if (!is_numeric($data['coefficient']) || (float) $data['coefficient'] < 0) {
            $errors['coefficient'] = "Le coefficient doit être un nombre positif ou nul.";
        }
        return $errors;
    }
}
