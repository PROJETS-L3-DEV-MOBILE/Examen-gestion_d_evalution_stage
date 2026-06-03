<div class="d-flex align-items-center mb-4">
    <a href="index.php?controller=stage&action=index" class="btn btn-sm btn-outline-secondary me-3">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h1 class="h3 mb-0">
            <i class="bi bi-pencil-square text-warning me-2"></i>Saisie des evaluations
        </h1>
        <p class="text-muted mb-0 small">
            <?= htmlspecialchars($stage['stagiaire_prenom'] . ' ' . $stage['stagiaire_nom']) ?>
            &mdash; <?= htmlspecialchars($stage['sujet']) ?>
            &mdash; <?= htmlspecialchars($stage['entreprise_nom']) ?>
        </p>
    </div>
</div>

<!-- Info sur le bareme -->
<div class="alert alert-info d-flex align-items-center mb-4" role="alert">
    <i class="bi bi-info-circle me-2 fs-5"></i>
    <span>
        Bareme de notation : <strong>0 a <?= $stage['bareme'] ?></strong>.
        Les evaluations existantes sont pre-remplies et peuvent etre modifiees.
    </span>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form method="POST" action="index.php?controller=evaluation&action=storeeval">
            <input type="hidden" name="stage_id" value="<?= $stage['numero_stage'] ?>">

            <?php if (empty($criteres)): ?>
                <div class="alert alert-warning">
                    Aucun critere d'evaluation defini.
                    <a href="index.php?controller=critere&action=create">Creer un critere</a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Critere d'evaluation</th>
                                <th class="text-center" style="width:80px">Coef.</th>
                                <th style="width:160px">
                                    Note <span class="text-muted small">(0 - <?= $stage['bareme'] ?>)</span>
                                </th>
                                <th>Observation</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($criteres as $critere): ?>
                                <?php
                                    $cid      = $critere['id_critere'];
                                    $existing = $evalMap[$cid] ?? null;
                                    $hasError = !empty($errors[$cid]);
                                ?>
                                <tr>
                                    <td class="fw-semibold"><?= htmlspecialchars($critere['libelle_critere']) ?></td>
                                    <td class="text-center">
                                        <span class="badge bg-secondary"><?= $critere['coefficient'] ?></span>
                                    </td>
                                    <td>
                                        <input type="number"
                                               name="notes[<?= $cid ?>]"
                                               class="form-control form-control-sm <?= $hasError ? 'is-invalid' : '' ?>"
                                               step="0.5"
                                               min="0"
                                               max="<?= $stage['bareme'] ?>"
                                               placeholder="0"
                                               value="<?= htmlspecialchars($existing['note'] ?? '') ?>">
                                        <?php if ($hasError): ?>
                                            <div class="invalid-feedback"><?= htmlspecialchars($errors[$cid]) ?></div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <input type="text"
                                               name="observations[<?= $cid ?>]"
                                               class="form-control form-control-sm"
                                               placeholder="Observation (optionnel)"
                                               value="<?= htmlspecialchars($existing['observation'] ?? '') ?>">
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-3">
                    <a href="index.php?controller=stage&action=index" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-warning text-dark">
                        <i class="bi bi-save me-1"></i>Enregistrer les evaluations
                    </button>
                </div>
            <?php endif; ?>
        </form>
    </div>
</div>
