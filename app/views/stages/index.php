<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0"><i class="bi bi-briefcase-fill text-warning me-2"></i>Stages</h1>
    <a href="index.php?controller=stage&action=create" class="btn btn-warning text-dark">
        <i class="bi bi-plus-lg me-1"></i>Attribuer un stage
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <?php if (empty($stages)): ?>
            <p class="text-center text-muted py-5">Aucun stage enregistre.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Stagiaire</th>
                            <th>Sujet</th>
                            <th>Entreprise</th>
                            <th>Periode</th>
                            <th class="text-center">Bareme</th>
                            <th class="text-center">Statut</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($stages as $s): ?>
                            <tr>
                                <td class="text-muted small"><?= $s['numero_stage'] ?></td>
                                <td class="fw-semibold">
                                    <?= htmlspecialchars($s['stagiaire_prenom'] . ' ' . $s['stagiaire_nom']) ?>
                                    <div class="text-muted small"><?= htmlspecialchars($s['ecole'] ?? '') ?></div>
                                </td>
                                <td><?= htmlspecialchars($s['sujet']) ?></td>
                                <td>
                                    <?= htmlspecialchars($s['entreprise_nom']) ?>
                                    <div class="text-muted small"><?= htmlspecialchars($s['ville'] ?? '') ?></div>
                                </td>
                                <td class="text-nowrap small">
                                    <?= date('d/m/Y', strtotime($s['dateDebut'])) ?>
                                    &rarr;
                                    <?= date('d/m/Y', strtotime($s['dateFin'])) ?>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-secondary">/<?= $s['bareme'] ?></span>
                                </td>
                                <td class="text-center">
                                    <span class="badge <?= $s['statut'] === 'actif' ? 'bg-success' : 'bg-secondary' ?>">
                                        <?= ucfirst($s['statut']) ?>
                                    </span>
                                </td>
                                <td class="text-end text-nowrap">
                                    <a href="index.php?controller=evaluation&action=saisie&stage=<?= $s['numero_stage'] ?>"
                                       class="btn btn-sm btn-outline-info me-1" title="Evaluer">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="index.php?controller=evaluation&action=fiche&stage=<?= $s['numero_stage'] ?>"
                                       class="btn btn-sm btn-outline-secondary me-1" title="Fiche">
                                        <i class="bi bi-clipboard-data"></i>
                                    </a>
                                    <a href="index.php?controller=stage&action=edit&id=<?= $s['numero_stage'] ?>"
                                       class="btn btn-sm btn-outline-primary me-1" title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="index.php?controller=stage&action=delete&id=<?= $s['numero_stage'] ?>"
                                       class="btn btn-sm btn-outline-danger"
                                       title="Supprimer"
                                       onclick="return confirm('Supprimer ce stage et toutes ses evaluations ?')">
                                        <i class="bi bi-trash"></i>
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
