<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0"><i class="bi bi-house-fill text-primary me-2"></i>Tableau de bord</h1>
</div>

<!-- Statistiques -->
<div class="row g-4 mb-5">
    <div class="col-sm-6 col-xl-3">
        <div class="card card-stat border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-primary bg-opacity-10 text-primary rounded-3 p-3">
                    <i class="bi bi-person-badge fs-3"></i>
                </div>
                <div>
                    <div class="fs-1 fw-bold text-primary"><?= $stats['nb_stagiaires'] ?></div>
                    <div class="text-muted small">Stagiaires</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card card-stat border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-success bg-opacity-10 text-success rounded-3 p-3">
                    <i class="bi bi-building fs-3"></i>
                </div>
                <div>
                    <div class="fs-1 fw-bold text-success"><?= $stats['nb_entreprises'] ?></div>
                    <div class="text-muted small">Entreprises</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card card-stat border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-warning bg-opacity-10 text-warning rounded-3 p-3">
                    <i class="bi bi-briefcase fs-3"></i>
                </div>
                <div>
                    <div class="fs-1 fw-bold text-warning"><?= $stats['nb_stages'] ?></div>
                    <div class="text-muted small">Stages</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card card-stat border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-info bg-opacity-10 text-info rounded-3 p-3">
                    <i class="bi bi-list-check fs-3"></i>
                </div>
                <div>
                    <div class="fs-1 fw-bold text-info"><?= $stats['nb_criteres'] ?></div>
                    <div class="text-muted small">Criteres</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Derniers stages -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0"><i class="bi bi-clock-history text-secondary me-2"></i>Derniers stages</h5>
        <a href="index.php?controller=stage&action=index" class="btn btn-sm btn-outline-primary">Voir tout</a>
    </div>
    <div class="card-body p-0">
        <?php if (empty($derniers_stages)): ?>
            <p class="text-center text-muted py-4">Aucun stage enregistré.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Stagiaire</th>
                            <th>Sujet</th>
                            <th>Entreprise</th>
                            <th>Periode</th>
                            <th>Statut</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($derniers_stages as $s): ?>
                            <tr>
                                <td><?= htmlspecialchars($s['stagiaire_prenom'] . ' ' . $s['stagiaire_nom']) ?></td>
                                <td><?= htmlspecialchars($s['sujet']) ?></td>
                                <td><?= htmlspecialchars($s['entreprise_nom']) ?></td>
                                <td class="text-nowrap">
                                    <?= date('d/m/Y', strtotime($s['dateDebut'])) ?>
                                    &rarr;
                                    <?= date('d/m/Y', strtotime($s['dateFin'])) ?>
                                </td>
                                <td>
                                    <span class="badge <?= $s['statut'] === 'actif' ? 'bg-success' : 'bg-secondary' ?>">
                                        <?= ucfirst($s['statut']) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="index.php?controller=evaluation&action=fiche&stage=<?= $s['numero_stage'] ?>"
                                       class="btn btn-sm btn-outline-info">
                                        <i class="bi bi-clipboard-data me-1"></i>Fiche
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
