<?php
/**
 * Contrôleur CritereEvaluation - CRUD des critères
 */

class CritereController extends Controller
{
    private CritereModel $model;

    public function __construct()
    {
        $this->model = new CritereModel();
    }

    public function index(): void
    {
        $criteres = $this->model->getAll();
        $this->render('criteres/index', ['criteres' => $criteres], 'Critères d\'évaluation');
    }

    public function create(): void
    {
        $this->render('criteres/form', ['critere' => null, 'errors' => []], 'Nouveau critère');
    }

    public function store(): void
    {
        $data   = $this->collectFormData();
        $errors = $this->validate($data);

        if (!empty($errors)) {
            $this->render('criteres/form', ['critere' => $data, 'errors' => $errors], 'Nouveau critère');
            return;
        }

        try {
            $this->model->create($data);
            $this->redirect(BASE_URL . '?controller=critere&action=index');
        } catch (InvalidArgumentException $e) {
            $this->render('criteres/form', ['critere' => $data, 'errors' => [$e->getMessage()]], 'Nouveau critère');
        }
    }

    public function edit(): void
    {
        $id      = (int) $this->get('id');
        $critere = $this->model->getById($id);

        if (!$critere) {
            $this->redirect(BASE_URL . '?controller=critere&action=index');
            return;
        }

        $this->render('criteres/form', ['critere' => $critere, 'errors' => []], 'Modifier le critère');
    }

    public function update(): void
    {
        $id     = (int) $this->post('id');
        $data   = $this->collectFormData();
        $errors = $this->validate($data);

        if (!empty($errors)) {
            $data['id_critere'] = $id;
            $this->render('criteres/form', ['critere' => $data, 'errors' => $errors], 'Modifier le critère');
            return;
        }

        try {
            $this->model->update($id, $data);
            $this->redirect(BASE_URL . '?controller=critere&action=index');
        } catch (InvalidArgumentException $e) {
            $data['id_critere'] = $id;
            $this->render('criteres/form', ['critere' => $data, 'errors' => [$e->getMessage()]], 'Modifier le critère');
        }
    }

    public function delete(): void
    {
        $id = (int) $this->get('id');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->delete($id);
        }
        $this->redirect(BASE_URL . '?controller=critere&action=index');
    }

    private function collectFormData(): array
    {
        return [
            'libelle_critere' => $this->post('libelle_critere', ''),
            'coefficient'     => $this->post('coefficient', 0),
        ];
    }

    private function validate(array $data): array
    {
        $errors = [];
        if (empty($data['libelle_critere']))    $errors[] = "Le libellé est obligatoire.";
        if (!is_numeric($data['coefficient']))  $errors[] = "Le coefficient doit être un nombre.";
        if ((float)$data['coefficient'] < 0)    $errors[] = "Le coefficient ne peut pas être négatif.";
        return $errors;
    }
}