<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0"><i class="bi bi-list-check text-info me-2"></i>Criteres d'evaluation</h1>
    <a href="index.php?controller=critere&action=create" class="btn btn-info text-white">
        <i class="bi bi-plus-lg me-1"></i>Nouveau critere
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <?php if (empty($criteres)): ?>
            <p class="text-center text-muted py-5">Aucun critere enregistre.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Libelle du critere</th>
                            <th class="text-center">Coefficient</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($criteres as $c): ?>
                            <tr>
                                <td class="text-muted small"><?= $c['id_critere'] ?></td>
                                <td class="fw-semibold"><?= htmlspecialchars($c['libelle_critere']) ?></td>
                                <td class="text-center">
                                    <span class="badge bg-info text-dark fs-6 px-3"><?= $c['coefficient'] ?></span>
                                </td>
                                <td class="text-end text-nowrap">
                                    <a href="index.php?controller=critere&action=edit&id=<?= $c['id_critere'] ?>"
                                       class="btn btn-sm btn-outline-primary me-1" title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="index.php?controller=critere&action=delete&id=<?= $c['id_critere'] ?>"
                                       class="btn btn-sm btn-outline-danger"
                                       title="Supprimer"
                                       onclick="return confirm('Supprimer ce critere ?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="2" class="text-end fw-bold">Somme des coefficients :</td>
                            <td class="text-center fw-bold text-info">
                                <?= array_sum(array_column($criteres, 'coefficient')) ?>
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
