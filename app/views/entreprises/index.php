<div class="list-page-header">
    <h1><i class="bi bi-building-fill text-success"></i>Entreprises</h1>
    <a href="index.php?controller=entreprise&action=create" class="btn btn-success">
        <i class="bi bi-plus-lg me-1"></i>Nouvelle entreprise
    </a>
</div>

<div class="list-card">
    <?php if (empty($entreprises)): ?>
        <div class="empty-state">
            <i class="bi bi-building"></i>
            <p>Aucune entreprise enregistrée.</p>
        </div>
    <?php else: ?>
        <div class="list-card-toolbar">
            <span class="record-count"><i class="bi bi-table me-1"></i>Total : <span><?= count($entreprises) ?></span></span>
        </div>
        <div class="table-responsive">
            <table class="table list-table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="col-id">#</th>
                        <th>Nom</th>
                        <th class="hide-mobile">Secteur d'activité</th>
                        <th>Ville</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($entreprises as $e): ?>
                        <tr>
                            <td class="col-id"><?= $e['numero_entreprise'] ?></td>
                            <td class="col-name"><?= htmlspecialchars($e['nom']) ?></td>
                            <td class="hide-mobile text-muted"><?= htmlspecialchars($e['secteur_activite'] ?? '') ?></td>
                            <td class="text-muted"><?= htmlspecialchars($e['ville'] ?? '') ?></td>
                            <td class="text-end text-nowrap">
                                <div class="dropdown-menu-container">
                                    <button class="dropdown-menu-trigger" title="Actions">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu-content">
                                        <li><a href="index.php?controller=entreprise&action=edit&id=<?= $e['numero_entreprise'] ?>" class="dropdown-menu-item">
                                            <i class="bi bi-pencil"></i> Modifier
                                        </a></li>
                                        <li><a href="index.php?controller=entreprise&action=delete&id=<?= $e['numero_entreprise'] ?>" class="dropdown-menu-item danger" data-confirm="Supprimer cette entreprise ?">
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
