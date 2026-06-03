<?php
/**
 * Contrôleur Evaluation
 * 
 * Gère les évaluations par critère pour chaque stage.
 * Inclut la génération de PDF via mPDF.
 */

class EvaluationController extends Controller
{
    private EvaluationModel $model;
    private StageModel      $stageModel;
    private CritereModel    $critereModel;

    public function __construct()
    {
        $this->model        = new EvaluationModel();
        $this->stageModel   = new StageModel();
        $this->critereModel = new CritereModel();
    }

    /**
     * Liste les évaluations d'un stage donné.
     */
    public function index(): void
    {
        $idStage    = (int) $this->get('stage_id');
        $stage      = $this->stageModel->getById($idStage);
        $evaluations = $this->model->getByStage($idStage);

        // Calcul de la note finale pour affichage
        $noteFinale = $this->model->calculerNoteFinale($idStage);

        $this->render('evaluations/index', [
            'stage'       => $stage,
            'evaluations' => $evaluations,
            'noteFinale'  => $noteFinale,
        ], 'Évaluations');
    }

    /**
     * Formulaire d'ajout d'une évaluation.
     */
    public function create(): void
    {
        $idStage = (int) $this->get('stage_id');
        $stage   = $this->stageModel->getById($idStage);
        $criteres = $this->critereModel->getAll();

        $this->render('evaluations/form', [
            'evaluation' => null,
            'stage'      => $stage,
            'criteres'   => $criteres,
            'errors'     => [],
        ], 'Nouvelle évaluation');
    }

    /**
     * Sauvegarde une nouvelle évaluation et recalcule la note finale.
     */
    public function store(): void
    {
        $idStage = (int) $this->post('stage_id');
        $data    = $this->collectFormData($idStage);
        $errors  = $this->validate($data);

        if (!empty($errors)) {
            $this->render('evaluations/form', [
                'evaluation' => $data,
                'stage'      => $this->stageModel->getById($idStage),
                'criteres'   => $this->critereModel->getAll(),
                'errors'     => $errors,
            ], 'Nouvelle évaluation');
            return;
        }

        try {
            $this->model->create($data);
            // Recalcul automatique après chaque modification (règle métier)
            $this->model->calculerNoteFinale($idStage);
            $this->redirect(BASE_URL . '?controller=evaluation&action=index&stage_id=' . $idStage);
        } catch (InvalidArgumentException $e) {
            $this->render('evaluations/form', [
                'evaluation' => $data,
                'stage'      => $this->stageModel->getById($idStage),
                'criteres'   => $this->critereModel->getAll(),
                'errors'     => [$e->getMessage()],
            ], 'Nouvelle évaluation');
        }
    }

    /**
     * Formulaire de modification d'une évaluation.
     */
    public function edit(): void
    {
        $id         = (int) $this->get('id');
        $evaluation = $this->model->getById($id);

        if (!$evaluation) {
            $this->redirect(BASE_URL . '?controller=stage&action=index');
            return;
        }

        $this->render('evaluations/form', [
            'evaluation' => $evaluation,
            'stage'      => $this->stageModel->getById($evaluation['numero_stage']),
            'criteres'   => $this->critereModel->getAll(),
            'errors'     => [],
        ], 'Modifier l\'évaluation');
    }

    /**
     * Met à jour une évaluation et recalcule la note finale.
     */
    public function update(): void
    {
        $id         = (int) $this->post('id');
        $evaluation = $this->model->getById($id);
        $idStage    = $evaluation['numero_stage'];
        $data       = $this->collectFormData($idStage);
        $errors     = $this->validate($data);

        if (!empty($errors)) {
            $this->render('evaluations/form', [
                'evaluation' => array_merge($data, ['numero_evaluation' => $id]),
                'stage'      => $this->stageModel->getById($idStage),
                'criteres'   => $this->critereModel->getAll(),
                'errors'     => $errors,
            ], 'Modifier l\'évaluation');
            return;
        }

        try {
            $this->model->update($id, $data);
            // Recalcul automatique de la note finale après modification (règle métier)
            $this->model->calculerNoteFinale($idStage);
            $this->redirect(BASE_URL . '?controller=evaluation&action=index&stage_id=' . $idStage);
        } catch (InvalidArgumentException $e) {
            $this->render('evaluations/form', [
                'evaluation' => array_merge($data, ['numero_evaluation' => $id]),
                'stage'      => $this->stageModel->getById($idStage),
                'criteres'   => $this->critereModel->getAll(),
                'errors'     => [$e->getMessage()],
            ], 'Modifier l\'évaluation');
        }
    }

    /**
     * Supprime une évaluation.
     */
    public function delete(): void
    {
        $id         = (int) $this->get('id');
        $evaluation = $this->model->getById($id);
        $idStage    = $evaluation ? $evaluation['numero_stage'] : 0;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->delete($id);
        }

        $this->redirect(BASE_URL . '?controller=evaluation&action=index&stage_id=' . $idStage);
    }

    /**
     * Affiche la fiche d'évaluation complète d'un stage.
     */
    public function fiche(): void
    {
        $idStage   = (int) $this->get('stage_id');
        $stage     = $this->stageModel->getById($idStage);
        $lignes    = $this->model->getFicheEvaluation($idStage);
        $noteFinale = $this->model->calculerNoteFinale($idStage);

        $this->render('evaluations/fiche', [
            'stage'      => $stage,
            'lignes'     => $lignes,
            'noteFinale' => $noteFinale,
        ], 'Fiche d\'évaluation');
    }

    /**
     * Génère et télécharge le PDF de la fiche d'évaluation via mPDF.
     */
    public function pdf(): void
    {
        $idStage    = (int) $this->get('stage_id');
        $stage      = $this->stageModel->getById($idStage);
        $lignes     = $this->model->getFicheEvaluation($idStage);
        $noteFinale = $this->model->calculerNoteFinale($idStage);

        // Vérification que mPDF est disponible
        $mpdfPath = ROOT_PATH . '/vendor/autoload.php';
        if (!file_exists($mpdfPath)) {
            die("mPDF n'est pas installé. Exécutez : composer require mpdf/mpdf");
        }
        require_once $mpdfPath;

        // Construction du contenu HTML du PDF
        ob_start();
        require VIEWS_PATH . '/pdf/fiche_evaluation.php';
        $html = ob_get_clean();

        // Initialisation de mPDF avec format A4
        $mpdf = new \Mpdf\Mpdf([
            'format'      => 'A4',
            'orientation' => 'P',
            'margin_top'  => 20,
            'margin_left' => 20,
            'margin_right'=> 20,
        ]);

        $mpdf->SetTitle("Procès-verbal d'évaluation de stage");
        $mpdf->WriteHTML($html);

        // Force le téléchargement du fichier PDF
        $mpdf->Output("evaluation_stage_{$idStage}.pdf", \Mpdf\Output\Destination::DOWNLOAD);
        exit;
    }

    // ─── Méthodes privées ───────────────────────────────────────────────────────

    private function collectFormData(int $idStage): array
    {
        return [
            'note'         => $this->post('note', 0),
            'observation'  => $this->post('observation', ''),
            'id_critere'   => (int) $this->post('id_critere', 0),
            'numero_stage' => $idStage,
        ];
    }

    private function validate(array $data): array
    {
        $errors = [];
        if ($data['id_critere'] <= 0)         $errors[] = "Veuillez sélectionner un critère.";
        if (!is_numeric($data['note']))        $errors[] = "La note doit être un nombre.";
        if ((float)$data['note'] < 0 || (float)$data['note'] > 20) {
            $errors[] = "La note doit être comprise entre 0 et 20.";
        }
        return $errors;
    }
}