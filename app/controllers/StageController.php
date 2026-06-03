<?php
/**
 * Contrôleur StageController – attribution et gestion des stages.
 */
class StageController extends Controller
{
    private Stage       $model;
    private Stagiaire   $stagiaireModel;
    private Entreprise  $entrepriseModel;

    public function __construct()
    {
        $this->model           = new Stage();
        $this->stagiaireModel  = new Stagiaire();
        $this->entrepriseModel = new Entreprise();
    }

    public function index(): void
    {
        $stages = $this->model->findAllWithDetails();
        $this->render('stages/index', [
            'stages' => $stages,
            'flash'  => $this->getFlash(),
        ]);
    }

    /** Formulaire d'attribution d'un nouveau stage. */
    public function create(): void
    {
        $this->render('stages/form', [
            'stage'       => null,
            'action'      => 'store',
            'stagiaires'  => $this->stagiaireModel->findAll(),
            'entreprises' => $this->entrepriseModel->findAll(),
            'errors'      => [],
        ]);
    }

    public function store(): void
    {
        $data   = $this->getPostData();
        $errors = $this->validate($data);

        if (!empty($errors)) {
            $this->render('stages/form', [
                'stage'       => $data,
                'action'      => 'store',
                'stagiaires'  => $this->stagiaireModel->findAll(),
                'entreprises' => $this->entrepriseModel->findAll(),
                'errors'      => $errors,
            ]);
            return;
        }

        try {
            $this->model->create($data);
            $this->setFlash('success', "Stage attribué avec succès.");
            $this->redirect('index.php?controller=stage&action=index');
        } catch (Exception $e) {
            $errors['general'] = $e->getMessage();
            $this->render('stages/form', [
                'stage'       => $data,
                'action'      => 'store',
                'stagiaires'  => $this->stagiaireModel->findAll(),
                'entreprises' => $this->entrepriseModel->findAll(),
                'errors'      => $errors,
            ]);
        }
    }

    public function edit(): void
    {
        $id    = (int) ($_GET['id'] ?? 0);
        $stage = $this->model->findById($id);

        if (!$stage) {
            $this->setFlash('error', "Stage introuvable.");
            $this->redirect('index.php?controller=stage&action=index');
            return;
        }

        $this->render('stages/form', [
            'stage'       => $stage,
            'action'      => 'update',
            'stagiaires'  => $this->stagiaireModel->findAll(),
            'entreprises' => $this->entrepriseModel->findAll(),
            'errors'      => [],
        ]);
    }

    public function update(): void
    {
        $id     = (int) ($_POST['id'] ?? 0);
        $data   = $this->getPostData();
        $errors = $this->validate($data);

        if (!empty($errors)) {
            $data['numero_stage'] = $id;
            $this->render('stages/form', [
                'stage'       => $data,
                'action'      => 'update',
                'stagiaires'  => $this->stagiaireModel->findAll(),
                'entreprises' => $this->entrepriseModel->findAll(),
                'errors'      => $errors,
            ]);
            return;
        }

        try {
            $this->model->update($id, $data);
            $this->setFlash('success', "Stage mis à jour avec succès.");
            $this->redirect('index.php?controller=stage&action=index');
        } catch (Exception $e) {
            $errors['general']    = $e->getMessage();
            $data['numero_stage'] = $id;
            $this->render('stages/form', [
                'stage'       => $data,
                'action'      => 'update',
                'stagiaires'  => $this->stagiaireModel->findAll(),
                'entreprises' => $this->entrepriseModel->findAll(),
                'errors'      => $errors,
            ]);
        }
    }

    public function delete(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        try {
            $this->model->delete($id);
            $this->setFlash('success', "Stage supprimé.");
        } catch (Exception $e) {
            $this->setFlash('error', "Impossible de supprimer ce stage.");
        }
        $this->redirect('index.php?controller=stage&action=index');
    }

    /** Affiche les détails d'un stage. */
    public function show(): void
    {
        $id    = (int) ($_GET['id'] ?? 0);
        $stage = $this->model->findByIdWithDetails($id);

        if (!$stage) {
            $this->setFlash('error', "Stage introuvable.");
            $this->redirect('index.php?controller=stage&action=index');
            return;
        }

        $evalModel   = new Evaluation();
        $evaluations = $evalModel->findByStage($id);
        $noteFinale  = $this->model->getNoteFinale($id);

        $this->render('stages/show', [
            'stage'       => $stage,
            'evaluations' => $evaluations,
            'note_finale' => $noteFinale,
            'flash'       => $this->getFlash(),
        ]);
    }

    private function getPostData(): array
    {
        return [
            'sujet'             => trim($_POST['sujet']             ?? ''),
            'dateDebut'         => trim($_POST['dateDebut']         ?? ''),
            'dateFin'           => trim($_POST['dateFin']           ?? ''),
            'bareme'            => (int) ($_POST['bareme']          ?? 20),
            'statut'            => trim($_POST['statut']            ?? 'actif'),
            'numero_stagiaire'  => (int) ($_POST['numero_stagiaire']  ?? 0),
            'numero_entreprise' => (int) ($_POST['numero_entreprise'] ?? 0),
        ];
    }

    private function validate(array $data): array
    {
        $errors = [];
        if (empty($data['sujet']))              $errors['sujet']             = "Le sujet est obligatoire.";
        if (empty($data['dateDebut']))          $errors['dateDebut']         = "La date de début est obligatoire.";
        if (empty($data['dateFin']))            $errors['dateFin']           = "La date de fin est obligatoire.";
        if (empty($data['numero_stagiaire']))   $errors['numero_stagiaire']  = "Veuillez sélectionner un stagiaire.";
        if (empty($data['numero_entreprise']))  $errors['numero_entreprise'] = "Veuillez sélectionner une entreprise.";

        if (!empty($data['dateDebut']) && !empty($data['dateFin'])) {
            if (strtotime($data['dateDebut']) >= strtotime($data['dateFin'])) {
                $errors['dateFin'] = "La date de fin doit être postérieure à la date de début.";
            }
        }

        return $errors;
    }
}
