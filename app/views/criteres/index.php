<div class="list-page-header">
    <h1><i class="bi bi-list-check text-info"></i>Critères d'évaluation</h1>
    <a href="index.php?controller=critere&action=create" class="btn btn-info text-white">
        <i class="bi bi-plus-lg me-1"></i>Nouveau critère
    </a>
</div>

<div class="list-card">
    <?php if (empty($criteres)): ?>
        <div class="empty-state">
            <i class="bi bi-list-check"></i>
            <p>Aucun critère enregistré.</p>
        </div>
    <?php else: ?>
        <div class="list-card-toolbar">
            <span class="record-count"><i class="bi bi-table me-1"></i>Total : <span><?= count($criteres) ?></span></span>
            <span>Somme des coefficients :
                <strong class="text-info"><?= array_sum(array_column($criteres, 'coefficient')) ?></strong>
            </span>
        </div>
        <div class="table-responsive">
            <table class="table list-table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="col-id">#</th>
                        <th>Libellé du critère</th>
                        <th class="text-center">Coefficient</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($criteres as $c): ?>
                        <tr>
                            <td class="col-id"><?= $c['id_critere'] ?></td>
                            <td class="col-name"><?= htmlspecialchars($c['libelle_critere']) ?></td>
                            <td class="text-center">
                                <span class="badge bg-info text-dark px-3 py-2"><?= $c['coefficient'] ?></span>
                            </td>
                            <td class="text-end text-nowrap">
                                <div class="dropdown-menu-container">
                                    <button class="dropdown-menu-trigger" title="Actions">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu-content">
                                        <li><a href="index.php?controller=critere&action=edit&id=<?= $c['id_critere'] ?>" class="dropdown-menu-item">
                                            <i class="bi bi-pencil"></i> Modifier
                                        </a></li>
                                        <li><a href="index.php?controller=critere&action=delete&id=<?= $c['id_critere'] ?>" class="dropdown-menu-item danger" data-confirm="Supprimer ce critère ?">
                                            <i class="bi bi-trash"></i> Supprimer
                                        </a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
