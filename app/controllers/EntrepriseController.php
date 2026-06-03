<?php
/**
 * Contrôleur Entreprise - CRUD complet
 */

class EntrepriseController extends Controller
{
    private EntrepriseModel $model;

    public function __construct()
    {
        $this->model = new EntrepriseModel();
    }

    public function index(): void
    {
        $entreprises = $this->model->getAll();
        $this->render('entreprises/index', ['entreprises' => $entreprises], 'Entreprises');
    }

    public function create(): void
    {
        $this->render('entreprises/form', ['entreprise' => null, 'errors' => []], 'Nouvelle entreprise');
    }

    public function store(): void
    {
        $data   = $this->collectFormData();
        $errors = $this->validate($data);

        if (!empty($errors)) {
            $this->render('entreprises/form', ['entreprise' => $data, 'errors' => $errors], 'Nouvelle entreprise');
            return;
        }

        $this->model->create($data);
        $this->redirect(BASE_URL . '?controller=entreprise&action=index');
    }

    public function edit(): void
    {
        $id         = (int) $this->get('id');
        $entreprise = $this->model->getById($id);

        if (!$entreprise) {
            $this->redirect(BASE_URL . '?controller=entreprise&action=index');
            return;
        }

        $this->render('entreprises/form', ['entreprise' => $entreprise, 'errors' => []], 'Modifier l\'entreprise');
    }

    public function update(): void
    {
        $id     = (int) $this->post('id');
        $data   = $this->collectFormData();
        $errors = $this->validate($data);

        if (!empty($errors)) {
            $data['numero_entreprise'] = $id;
            $this->render('entreprises/form', ['entreprise' => $data, 'errors' => $errors], 'Modifier l\'entreprise');
            return;
        }

        $this->model->update($id, $data);
        $this->redirect(BASE_URL . '?controller=entreprise&action=index');
    }

    public function delete(): void
    {
        $id = (int) $this->get('id');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->delete($id);
        }
        $this->redirect(BASE_URL . '?controller=entreprise&action=index');
    }

    private function collectFormData(): array
    {
        return [
            'nom'              => $this->post('nom', ''),
            'secteur_activite' => $this->post('secteur_activite', ''),
            'ville'            => $this->post('ville', ''),
        ];
    }

    private function validate(array $data): array
    {
        $errors = [];
        if (empty($data['nom']))              $errors[] = "Le nom est obligatoire.";
        if (empty($data['secteur_activite'])) $errors[] = "Le secteur d'activité est obligatoire.";
        if (empty($data['ville']))            $errors[] = "La ville est obligatoire.";
        return $errors;
    }
}