<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? APP_NAME) ?> — GestionStage</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-icon">🎓</div>
        <span>GestionStage</span>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section">Principal</div>
        <a href="<?= BASE_URL ?>?controller=home&action=index"
           class="<?= ($_GET['controller'] ?? '') === 'home' ? 'active' : '' ?>">
            <span class="nav-icon">🏠</span> Tableau de bord
        </a>

        <div class="nav-section">Gestion</div>
        <a href="<?= BASE_URL ?>?controller=stagiaire&action=index"
           class="<?= ($_GET['controller'] ?? '') === 'stagiaire' ? 'active' : '' ?>">
            <span class="nav-icon">👨‍🎓</span> Stagiaires
        </a>
        <a href="<?= BASE_URL ?>?controller=entreprise&action=index"
           class="<?= ($_GET['controller'] ?? '') === 'entreprise' ? 'active' : '' ?>">
            <span class="nav-icon">🏢</span> Entreprises
        </a>
        <a href="<?= BASE_URL ?>?controller=stage&action=index"
           class="<?= ($_GET['controller'] ?? '') === 'stage' ? 'active' : '' ?>">
            <span class="nav-icon">📋</span> Stages
        </a>

        <div class="nav-section">Évaluation</div>
        <a href="<?= BASE_URL ?>?controller=critere&action=index"
           class="<?= ($_GET['controller'] ?? '') === 'critere' ? 'active' : '' ?>">
            <span class="nav-icon">⚖️</span> Critères
        </a>

        <div class="nav-section">Résultats</div>
        <a href="<?= BASE_URL ?>?controller=stagiaire&action=classement"
           class="<?= ($_GET['action'] ?? '') === 'classement' ? 'active' : '' ?>">
            <span class="nav-icon">🏆</span> Classement
        </a>
    </nav>
</aside>

<div class="main-wrapper">
    <div class="topbar">
        <h1><?= htmlspecialchars($title ?? '') ?></h1>
        <span style="font-size:13px; color:#6b7c93;">
            <?= date('d/m/Y') ?>
        </span>
    </div>

    <main class="page-content">
        <?= $content ?>
    </main>
</div>

</body>
</html>
