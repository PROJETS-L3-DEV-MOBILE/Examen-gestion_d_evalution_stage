<?php
/**
 * Contrôleur Home - Tableau de bord principal
 */

class HomeController extends Controller
{
    public function index(): void
    {
        // Instanciation des modèles pour les statistiques du tableau de bord
        $stagiaireModel  = new StagiaireModel();
        $entrepriseModel = new EntrepriseModel();
        $stageModel      = new StageModel();
        $critereModel    = new CritereModel();

        // Comptage rapide pour les cartes du dashboard
        $stats = [
            'nb_stagiaires'  => count($stagiaireModel->getAll()),
            'nb_entreprises' => count($entrepriseModel->getAll()),
            'nb_stages'      => count($stageModel->getAll()),
            'nb_criteres'    => count($critereModel->getAll()),
        ];

        // Classement des 5 meilleurs stagiaires pour l'aperçu
        $classement = array_slice($stagiaireModel->getClassement(), 0, 5);

        $this->render('home/index', [
            'stats'      => $stats,
            'classement' => $classement,
        ], 'Tableau de bord');
    }
}