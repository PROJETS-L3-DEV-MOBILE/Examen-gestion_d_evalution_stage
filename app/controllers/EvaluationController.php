<?php
/**
 * Contrôleur EvaluationController – saisie des évaluations, fiche individuelle et classement.
 */
class EvaluationController extends Controller
{
    private Evaluation       $evalModel;
    private Stage            $stageModel;
    private CritereEvaluation $critereModel;

    public function __construct()
    {
        $this->evalModel    = new Evaluation();
        $this->stageModel   = new Stage();
        $this->critereModel = new CritereEvaluation();
    }

    /** Affiche et traite le formulaire de saisie / modification des notes d'un stage. */
    public function saisie(): void
    {
        $stageId = (int) ($_GET['stage'] ?? 0);
        $stage   = $this->stageModel->findByIdWithDetails($stageId);

        if (!$stage) {
            $this->setFlash('error', "Stage introuvable.");
            $this->redirect('index.php?controller=stage&action=index');
            return;
        }

        $criteres    = $this->critereModel->findAll();
        $evaluations = $this->evalModel->findByStage($stageId);

        // Indexation des évaluations existantes par id_critere pour l'affichage pré-rempli
        $evalMap = [];
        foreach ($evaluations as $ev) {
            $evalMap[$ev['id_critere']] = $ev;
        }

        $this->render('evaluations/saisie', [
            'stage'    => $stage,
            'criteres' => $criteres,
            'evalMap'  => $evalMap,
            'flash'    => $this->getFlash(),
            'errors'   => [],
        ]);
    }

    /** Enregistre ou met à jour les évaluations soumises. */
    public function storeeval(): void
    {
        $stageId = (int) ($_POST['stage_id'] ?? 0);
        $stage   = $this->stageModel->findByIdWithDetails($stageId);

        if (!$stage) {
            $this->setFlash('error', "Stage introuvable.");
            $this->redirect('index.php?controller=stage&action=index');
            return;
        }

        $criteres = $this->critereModel->findAll();
        $bareme   = (float) $stage['bareme'];
        $errors   = [];

        // Vérification : la somme des coefficients ne doit pas être nulle
        if ($this->critereModel->sumCoefficients() == 0) {
            $this->setFlash('error', "Impossible d'évaluer : tous les coefficients sont nuls.");
            $this->redirect("index.php?controller=evaluation&action=saisie&stage={$stageId}");
            return;
        }

        // Validation de toutes les notes avant enregistrement
        $notes       = $_POST['notes']       ?? [];
        $observations = $_POST['observations'] ?? [];

        foreach ($criteres as $critere) {
            $critereId   = (int) $critere['id_critere'];
            $noteRaw     = $notes[$critereId] ?? '';

            if ($noteRaw === '' || $noteRaw === null) {
                continue; // Note non saisie : on saute ce critère
            }

            if (!is_numeric($noteRaw) || (float) $noteRaw < 0 || (float) $noteRaw > $bareme) {
                $errors[$critereId] = "La note doit être comprise entre 0 et {$bareme}.";
            }
        }

        if (!empty($errors)) {
            $evalMap = [];
            foreach ($this->evalModel->findByStage($stageId) as $ev) {
                $evalMap[$ev['id_critere']] = $ev;
            }
            $this->render('evaluations/saisie', [
                'stage'    => $stage,
                'criteres' => $criteres,
                'evalMap'  => $evalMap,
                'flash'    => null,
                'errors'   => $errors,
            ]);
            return;
        }

        // Enregistrement de chaque note
        foreach ($criteres as $critere) {
            $critereId   = (int) $critere['id_critere'];
            $noteRaw     = $notes[$critereId] ?? '';

            if ($noteRaw === '') continue;

            $this->evalModel->saveOrUpdate(
                $stageId,
                $critereId,
                (float) $noteRaw,
                trim($observations[$critereId] ?? ''),
                $bareme
            );
        }

        $this->setFlash('success', "Evaluations enregistrées. Note finale recalculée.");
        $this->redirect("index.php?controller=evaluation&action=fiche&stage={$stageId}");
    }

    /** Affiche la fiche d'évaluation individuelle d'un stage. */
    public function fiche(): void
    {
        $stageId = (int) ($_GET['stage'] ?? 0);
        $stage   = $this->stageModel->findByIdWithDetails($stageId);

        if (!$stage) {
            $this->setFlash('error', "Stage introuvable.");
            $this->redirect('index.php?controller=stage&action=index');
            return;
        }

        $evaluations = $this->evalModel->findByStage($stageId);
        $noteFinale  = $this->stageModel->getNoteFinale($stageId);

        $this->render('evaluations/fiche', [
            'stage'       => $stage,
            'evaluations' => $evaluations,
            'note_finale' => $noteFinale,
            'flash'       => $this->getFlash(),
        ]);
    }

    /** Affiche la fiche au format imprimable (sans layout). */
    public function imprimer(): void
    {
        $stageId = (int) ($_GET['stage'] ?? 0);
        $stage   = $this->stageModel->findByIdWithDetails($stageId);

        if (!$stage) {
            http_response_code(404);
            echo "Stage introuvable.";
            return;
        }

        $evaluations = $this->evalModel->findByStage($stageId);
        $noteFinale  = $this->stageModel->getNoteFinale($stageId);

        $this->renderRaw('evaluations/imprimer', [
            'stage'       => $stage,
            'evaluations' => $evaluations,
            'note_finale' => $noteFinale,
        ]);
    }

    /** Affiche le classement des stagiaires par note finale décroissante. */
    public function classement(): void
    {
        $classement = $this->stageModel->getClassement();
        $this->render('evaluations/classement', [
            'classement' => $classement,
            'flash'      => $this->getFlash(),
        ]);
    }
}
