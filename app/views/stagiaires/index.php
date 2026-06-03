<div class="list-page-header">
    <h1><i class="bi bi-person-badge-fill text-primary"></i>Stagiaires</h1>
    <a href="index.php?controller=stagiaire&action=create" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Nouveau stagiaire
    </a>
</div>

<div class="list-card">
    <?php if (empty($stagiaires)): ?>
        <div class="empty-state">
            <i class="bi bi-person-badge"></i>
            <p>Aucun stagiaire enregistré.</p>
        </div>
    <?php else: ?>
        <div class="list-card-toolbar">
            <span class="record-count"><i class="bi bi-table me-1"></i>Total : <span><?= count($stagiaires) ?></span></span>
        </div>
        <div class="table-responsive">
            <table class="table list-table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="col-id">#</th>
                        <th>Nom &amp; Prénom</th>
                        <th class="hide-mobile">Email</th>
                        <th class="hide-mobile">École</th>
                        <th>Filière</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($stagiaires as $s): ?>
                        <tr>
                            <td class="col-id"><?= $s['numero_stagiaire'] ?></td>
                            <td class="col-name">
                                <?= htmlspecialchars($s['prenom'] . ' ' . $s['nom']) ?>
                            </td>
                            <td class="hide-mobile text-muted"><?= htmlspecialchars($s['email'] ?? '') ?></td>
                            <td class="hide-mobile text-muted"><?= htmlspecialchars($s['ecole'] ?? '') ?></td>
                            <td><?= htmlspecialchars($s['filiere'] ?? '') ?></td>
                            <td class="text-end text-nowrap">
                                <div class="dropdown-menu-container">
                                    <button class="dropdown-menu-trigger" title="Actions">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu-content">
                                        <li><a href="index.php?controller=stagiaire&action=show&id=<?= $s['numero_stagiaire'] ?>" class="dropdown-menu-item">
                                            <i class="bi bi-eye"></i> Voir
                                        </a></li>
                                        <li><a href="index.php?controller=stagiaire&action=edit&id=<?= $s['numero_stagiaire'] ?>" class="dropdown-menu-item">
                                            <i class="bi bi-pencil"></i> Modifier
                                        </a></li>
                                        <li><a href="index.php?controller=stagiaire&action=delete&id=<?= $s['numero_stagiaire'] ?>" class="dropdown-menu-item danger" data-confirm="Supprimer ce stagiaire ?">
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
