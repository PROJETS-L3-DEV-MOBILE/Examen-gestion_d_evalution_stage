<?php
/**
 * Contrôleur Stage
 * 
 * Gère l'attribution des stages (stagiaire → entreprise)
 * avec validation des règles métier.
 */

class StageController extends Controller
{
    private StageModel      $model;
    private StagiaireModel  $stagiaireModel;
    private EntrepriseModel $entrepriseModel;

    public function __construct()
    {
        $this->model           = new StageModel();
        $this->stagiaireModel  = new StagiaireModel();
        $this->entrepriseModel = new EntrepriseModel();
    }

    public function index(): void
    {
        $stages = $this->model->getAll();
        $this->render('stages/index', ['stages' => $stages], 'Stages');
    }

    public function create(): void
    {
        // Passe les listes de stagiaires et entreprises pour les menus déroulants
        $this->render('stages/form', [
            'stage'       => null,
            'stagiaires'  => $this->stagiaireModel->getAll(),
            'entreprises' => $this->entrepriseModel->getAll(),
            'errors'      => [],
        ], 'Attribuer un stage');
    }

    public function store(): void
    {
        $data   = $this->collectFormData();
        $errors = $this->validate($data);

        if (!empty($errors)) {
            $this->render('stages/form', [
                'stage'       => $data,
                'stagiaires'  => $this->stagiaireModel->getAll(),
                'entreprises' => $this->entrepriseModel->getAll(),
                'errors'      => $errors,
            ], 'Attribuer un stage');
            return;
        }

        try {
            $this->model->create($data);
            $this->redirect(BASE_URL . '?controller=stage&action=index');
        } catch (InvalidArgumentException $e) {
            $this->render('stages/form', [
                'stage'       => $data,
                'stagiaires'  => $this->stagiaireModel->getAll(),
                'entreprises' => $this->entrepriseModel->getAll(),
                'errors'      => [$e->getMessage()],
            ], 'Attribuer un stage');
        }
    }

    public function edit(): void
    {
        $id    = (int) $this->get('id');
        $stage = $this->model->getById($id);

        if (!$stage) {
            $this->redirect(BASE_URL . '?controller=stage&action=index');
            return;
        }

        $this->render('stages/form', [
            'stage'       => $stage,
            'stagiaires'  => $this->stagiaireModel->getAll(),
            'entreprises' => $this->entrepriseModel->getAll(),
            'errors'      => [],
        ], 'Modifier le stage');
    }

    public function update(): void
    {
        $id     = (int) $this->post('id');
        $data   = $this->collectFormData();
        $errors = $this->validate($data);

        if (!empty($errors)) {
            $data['numero_stage'] = $id;
            $this->render('stages/form', [
                'stage'       => $data,
                'stagiaires'  => $this->stagiaireModel->getAll(),
                'entreprises' => $this->entrepriseModel->getAll(),
                'errors'      => $errors,
            ], 'Modifier le stage');
            return;
        }

        try {
            $this->model->update($id, $data);
            $this->redirect(BASE_URL . '?controller=stage&action=index');
        } catch (InvalidArgumentException $e) {
            $data['numero_stage'] = $id;
            $this->render('stages/form', [
                'stage'       => $data,
                'stagiaires'  => $this->stagiaireModel->getAll(),
                'entreprises' => $this->entrepriseModel->getAll(),
                'errors'      => [$e->getMessage()],
            ], 'Modifier le stage');
        }
    }

    public function delete(): void
    {
        $id = (int) $this->get('id');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->delete($id);
        }
        $this->redirect(BASE_URL . '?controller=stage&action=index');
    }

    private function collectFormData(): array
    {
        return [
            'sujet'             => $this->post('sujet', ''),
            'dateDebut'         => $this->post('dateDebut', ''),
            'dateFin'           => $this->post('dateFin', ''),
            'numero_stagiaire'  => (int) $this->post('numero_stagiaire', 0),
            'numero_entreprise' => (int) $this->post('numero_entreprise', 0),
        ];
    }

    private function validate(array $data): array
    {
        $errors = [];

        if (empty($data['sujet']))             $errors[] = "Le sujet du stage est obligatoire.";
        if (empty($data['dateDebut']))         $errors[] = "La date de début est obligatoire.";
        if (empty($data['dateFin']))           $errors[] = "La date de fin est obligatoire.";
        if ($data['numero_stagiaire'] <= 0)    $errors[] = "Veuillez sélectionner un stagiaire.";
        if ($data['numero_entreprise'] <= 0)   $errors[] = "Veuillez sélectionner une entreprise.";

        // Vérification de la cohérence des dates
        if (!empty($data['dateDebut']) && !empty($data['dateFin'])) {
            if ($data['dateDebut'] >= $data['dateFin']) {
                $errors[] = "La date de début doit être antérieure à la date de fin.";
            }
        }

        // Vérification du conflit de stage (un seul stage actif à la fois)
        if (empty($errors) && $data['numero_stagiaire'] > 0) {
            $excludeId = isset($_POST['id']) ? (int)$_POST['id'] : null;
            if ($this->model->hasConflict($data['numero_stagiaire'], $data['dateDebut'], $data['dateFin'], $excludeId)) {
                $errors[] = "Ce stagiaire a déjà un stage sur cette période. Un seul stage actif à la fois.";
            }
        }

        return $errors;
    }
}