<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">
        <i class="bi bi-trophy-fill text-warning me-2"></i>Classement des stagiaires
    </h1>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <?php if (empty($classement)): ?>
            <div class="text-center py-5">
                <i class="bi bi-trophy fs-1 text-muted"></i>
                <p class="text-muted mt-3">Aucun stagiaire evalue pour le moment.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" style="width:60px">Rang</th>
                            <th>Stagiaire</th>
                            <th>Ecole / Filiere</th>
                            <th>Sujet du stage</th>
                            <th>Entreprise</th>
                            <th class="text-center">Note finale</th>
                            <th>Fiche</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $rang = 1; foreach ($classement as $row): ?>
                            <tr class="<?= $rang === 1 ? 'table-warning' : ($rang === 2 ? 'table-light' : '') ?>">
                                <td class="text-center fw-bold">
                                    <?php if ($rang === 1): ?>
                                        <i class="bi bi-trophy-fill text-warning fs-5"></i>
                                    <?php elseif ($rang === 2): ?>
                                        <span class="text-secondary fw-bold">2</span>
                                    <?php elseif ($rang === 3): ?>
                                        <span class="text-info fw-bold">3</span>
                                    <?php else: ?>
                                        <?= $rang ?>
                                    <?php endif; ?>
                                </td>
                                <td class="fw-semibold">
                                    <?= htmlspecialchars($row['prenom'] . ' ' . $row['nom']) ?>
                                </td>
                                <td class="text-muted small">
                                    <?= htmlspecialchars($row['ecole'] ?? '') ?>
                                    <?php if (!empty($row['filiere'])): ?>
                                        <br><?= htmlspecialchars($row['filiere']) ?>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($row['sujet']) ?></td>
                                <td>
                                    <?= htmlspecialchars($row['entreprise_nom']) ?>
                                    <div class="text-muted small"><?= htmlspecialchars($row['ville'] ?? '') ?></div>
                                </td>
                                <td class="text-center">
                                    <?php if ($row['note_finale'] !== null): ?>
                                        <?php $pct = ($row['bareme'] > 0) ? ($row['note_finale'] / $row['bareme']) * 100 : 0; ?>
                                        <span class="badge fs-6 px-3 py-2
                                            <?= $pct >= 80 ? 'bg-success' : ($pct >= 60 ? 'bg-primary' : ($pct >= 40 ? 'bg-warning text-dark' : 'bg-danger')) ?>">
                                            <?= round($row['note_finale'], 2) ?> / <?= $row['bareme'] ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted fst-italic small">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="index.php?controller=evaluation&action=fiche&stage=<?= $row['numero_stage'] ?>"
                                       class="btn btn-sm btn-outline-info">
                                        <i class="bi bi-clipboard-data"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php $rang++; endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
