<div class="d-flex align-items-center mb-4">
    <a href="index.php?controller=stage&action=index" class="btn btn-sm btn-outline-secondary me-3">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h1 class="h3 mb-0">
        <i class="bi bi-briefcase text-warning me-2"></i>
        <?= htmlspecialchars($stage['sujet']) ?>
    </h1>
</div>

<div class="row g-4">
    <!-- Details du stage -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-warning bg-opacity-25 border-bottom py-3">
                <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Details du stage</h5>
            </div>
            <div class="card-body">
                <dl class="row mb-0 small">
                    <dt class="col-5 text-muted">Stagiaire</dt>
                    <dd class="col-7 fw-semibold">
                        <?= htmlspecialchars($stage['stagiaire_prenom'] . ' ' . $stage['stagiaire_nom']) ?>
                    </dd>

                    <dt class="col-5 text-muted">Ecole</dt>
                    <dd class="col-7"><?= htmlspecialchars($stage['ecole'] ?? '-') ?></dd>

                    <dt class="col-5 text-muted">Filiere</dt>
                    <dd class="col-7"><?= htmlspecialchars($stage['filiere'] ?? '-') ?></dd>

                    <dt class="col-5 text-muted">Entreprise</dt>
                    <dd class="col-7 fw-semibold"><?= htmlspecialchars($stage['entreprise_nom']) ?></dd>

                    <dt class="col-5 text-muted">Ville</dt>
                    <dd class="col-7"><?= htmlspecialchars($stage['ville'] ?? '-') ?></dd>

                    <dt class="col-5 text-muted">Periode</dt>
                    <dd class="col-7">
                        <?= date('d/m/Y', strtotime($stage['dateDebut'])) ?>
                        &rarr;
                        <?= date('d/m/Y', strtotime($stage['dateFin'])) ?>
                    </dd>

                    <dt class="col-5 text-muted">Bareme</dt>
                    <dd class="col-7">sur <?= $stage['bareme'] ?></dd>

                    <dt class="col-5 text-muted">Statut</dt>
                    <dd class="col-7">
                        <span class="badge <?= $stage['statut'] === 'actif' ? 'bg-success' : 'bg-secondary' ?>">
                            <?= ucfirst($stage['statut']) ?>
                        </span>
                    </dd>

                    <dt class="col-5 text-muted fw-bold">Note finale</dt>
                    <dd class="col-7">
                        <?php if ($note_finale !== null): ?>
                            <span class="badge bg-primary fs-6"><?= $note_finale ?>/<?= $stage['bareme'] ?></span>
                        <?php else: ?>
                            <span class="text-muted fst-italic">Non calculee</span>
                        <?php endif; ?>
                    </dd>
                </dl>
            </div>
            <div class="card-footer bg-white d-flex gap-2">
                <a href="index.php?controller=evaluation&action=saisie&stage=<?= $stage['numero_stage'] ?>"
                   class="btn btn-sm btn-warning text-dark">
                    <i class="bi bi-pencil-square me-1"></i>Evaluer
                </a>
                <a href="index.php?controller=evaluation&action=fiche&stage=<?= $stage['numero_stage'] ?>"
                   class="btn btn-sm btn-outline-info">
                    <i class="bi bi-clipboard-data me-1"></i>Fiche
                </a>
            </div>
        </div>
    </div>

    <!-- Evaluations -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0"><i class="bi bi-check2-square text-info me-2"></i>Evaluations saisies</h5>
            </div>
            <div class="card-body p-0">
                <?php if (empty($evaluations)): ?>
                    <p class="text-center text-muted py-4">Aucune evaluation pour ce stage.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-sm align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Critere</th>
                                    <th class="text-center">Coef.</th>
                                    <th class="text-center">Note</th>
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
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
