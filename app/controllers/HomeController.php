<?php
/**
 * Contrôleur Home – affiche le tableau de bord avec les statistiques générales.
 */
class HomeController extends Controller
{
    public function index(): void
    {
        $stagiaireModel  = new Stagiaire();
        $entrepriseModel = new Entreprise();
        $stageModel      = new Stage();
        $critereModel    = new CritereEvaluation();

        $stats = [
            'nb_stagiaires'  => $stagiaireModel->count(),
            'nb_entreprises' => $entrepriseModel->count(),
            'nb_stages'      => $stageModel->count(),
            'nb_criteres'    => $critereModel->count(),
        ];

        // Récupérer les derniers stages pour le tableau de bord
        $derniers_stages = array_slice($stageModel->findAllWithDetails(), 0, 5);

        $this->render('home/index', [
            'stats'          => $stats,
            'derniers_stages' => $derniers_stages,
            'flash'          => $this->getFlash(),
        ]);
    }
}
