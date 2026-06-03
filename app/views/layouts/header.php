<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Evaluations de Stage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') ?>/public/css/style.css" rel="stylesheet">
</head>
<body>

<!-- Barre de navigation principale -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="index.php">
            <i class="bi bi-mortarboard-fill me-2"></i>GestStage
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">
                        <i class="bi bi-house me-1"></i>Accueil
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?controller=stagiaire&action=index">
                        <i class="bi bi-person-badge me-1"></i>Stagiaires
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?controller=entreprise&action=index">
                        <i class="bi bi-building me-1"></i>Entreprises
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?controller=stage&action=index">
                        <i class="bi bi-briefcase me-1"></i>Stages
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?controller=critere&action=index">
                        <i class="bi bi-list-check me-1"></i>Criteres
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?controller=evaluation&action=classement">
                        <i class="bi bi-trophy me-1"></i>Classement
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Contenu principal -->
<main class="container-fluid py-4 px-4">

<?php if (!empty($flash)): ?>
    <div class="alert alert-<?= $flash['type'] === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
        <i class="bi bi-<?= $flash['type'] === 'success' ? 'check-circle' : 'exclamation-triangle' ?> me-2"></i>
        <?= htmlspecialchars($flash['message']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>
