<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center">
        <a href="index.php?controller=stage&action=index" class="btn btn-sm btn-outline-secondary me-3">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h1 class="h3 mb-0">
            <i class="bi bi-clipboard-data text-info me-2"></i>Fiche d'evaluation
        </h1>
    </div>
    <div class="d-flex gap-2">
        <a href="index.php?controller=evaluation&action=saisie&stage=<?= $stage['numero_stage'] ?>"
           class="btn btn-outline-warning">
            <i class="bi bi-pencil-square me-1"></i>Modifier
        </a>
        <a href="index.php?controller=evaluation&action=imprimer&stage=<?= $stage['numero_stage'] ?>"
           class="btn btn-outline-secondary" target="_blank">
            <i class="bi bi-printer me-1"></i>Imprimer / PDF
        </a>
    </div>
</div>

<!-- En-tete de la fiche -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-primary text-white py-3">
        <div class="d-flex justify-content-between align-items-center">
            <span class="fw-bold fs-5">
                <i class="bi bi-mortarboard me-2"></i>PROCES-VERBAL D'EVALUATION DE STAGE
            </span>
            <span class="badge bg-white text-primary"><?= $stage['statut'] === 'actif' ? 'En cours' : 'Termine' ?></span>
        </div>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <h6 class="text-muted text-uppercase small mb-2">Stagiaire</h6>
                <p class="mb-0 fw-semibold fs-5">
                    <?= htmlspecialchars($stage['stagiaire_prenom'] . ' ' . $stage['stagiaire_nom']) ?>
                </p>
                <p class="text-muted mb-0"><?= htmlspecialchars($stage['ecole'] ?? '') ?></p>
                <p class="text-muted mb-0"><?= htmlspecialchars($stage['filiere'] ?? '') ?></p>
                <p class="text-muted small"><?= htmlspecialchars($stage['stagiaire_email'] ?? '') ?></p>
            </div>
            <div class="col-md-6">
                <h6 class="text-muted text-uppercase small mb-2">Entreprise d'accueil</h6>
                <p class="mb-0 fw-semibold fs-5"><?= htmlspecialchars($stage['entreprise_nom']) ?></p>
                <p class="text-muted mb-0"><?= htmlspecialchars($stage['secteur_activite'] ?? '') ?></p>
                <p class="text-muted mb-0"><?= htmlspecialchars($stage['ville'] ?? '') ?></p>
            </div>
            <div class="col-12">
                <hr class="my-2">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Sujet :</strong> <?= htmlspecialchars($stage['sujet']) ?>
                    </div>
                    <div class="col-md-6">
                        <strong>Periode :</strong>
                        du <?= date('d/m/Y', strtotime($stage['dateDebut'])) ?>
                        au <?= date('d/m/Y', strtotime($stage['dateFin'])) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tableau des evaluations -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white border-bottom py-3">
        <h5 class="mb-0"><i class="bi bi-table text-secondary me-2"></i>Grille d'evaluation</h5>
    </div>
    <div class="card-body p-0">
        <?php if (empty($evaluations)): ?>
            <div class="text-center py-4">
                <p class="text-muted">Aucune evaluation enregistree pour ce stage.</p>
                <a href="index.php?controller=evaluation&action=saisie&stage=<?= $stage['numero_stage'] ?>"
                   class="btn btn-warning text-dark">
                    <i class="bi bi-pencil-square me-1"></i>Saisir les evaluations
                </a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Critere d'evaluation</th>
                            <th class="text-center">Coefficient</th>
                            <th class="text-center">Note /<?= $stage['bareme'] ?></th>
                            <th>Observation</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($evaluations as $ev): ?>
                            <tr>
                                <td><?= htmlspecialchars($ev['libelle_critere']) ?></td>
                                <td class="text-center"><?= $ev['coefficient'] ?></td>
                                <td class="text-center fw-bold"><?= $ev['note'] ?></td>
                                <td class="text-muted small"><?= htmlspecialchars($ev['observation'] ?? '') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="2" class="text-end fw-bold fs-5">NOTE FINALE :</td>
                            <td class="text-center">
                                <?php if ($note_finale !== null): ?>
                                    <span class="badge bg-primary fs-5 px-3 py-2">
                                        <?= $note_finale ?> / <?= $stage['bareme'] ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-muted fst-italic">Non calculee</span>
                                <?php endif; ?>
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Note de bas de fiche -->
<?php if ($note_finale !== null): ?>
<div class="alert alert-light border d-flex align-items-center">
    <i class="bi bi-calculator me-2 text-primary fs-5"></i>
    <small class="text-muted">
        Formule : Note finale = somme(note &times; coefficient) / somme(coefficients) =
        <strong><?= $note_finale ?></strong> / <?= $stage['bareme'] ?>
    </small>
</div>
<?php endif; ?>
