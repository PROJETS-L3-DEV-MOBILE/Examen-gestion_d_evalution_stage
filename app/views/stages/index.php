<div class="list-page-header">
    <h1><i class="bi bi-briefcase-fill text-warning"></i>Stages</h1>
    <a href="index.php?controller=stage&action=create" class="btn btn-warning text-dark">
        <i class="bi bi-plus-lg me-1"></i>Attribuer un stage
    </a>
</div>

<div class="list-card">
    <?php if (empty($stages)): ?>
        <div class="empty-state">
            <i class="bi bi-briefcase"></i>
            <p>Aucun stage enregistré.</p>
        </div>
    <?php else: ?>
        <div class="list-card-toolbar">
            <span class="record-count"><i class="bi bi-table me-1"></i>Total : <span><?= count($stages) ?></span></span>
        </div>
        <div class="table-responsive">
            <table class="table list-table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="col-id">#</th>
                        <th>Stagiaire</th>
                        <th>Sujet</th>
                        <th class="hide-mobile">Entreprise</th>
                        <th class="hide-mobile">Période</th>
                        <th class="text-center hide-mobile">Barème</th>
                        <th class="text-center">Statut</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($stages as $s): ?>
                        <tr>
                            <td class="col-id"><?= $s['numero_stage'] ?></td>
                            <td class="col-name">
                                <?= htmlspecialchars($s['stagiaire_prenom'] . ' ' . $s['stagiaire_nom']) ?>
                                <div class="sub"><?= htmlspecialchars($s['ecole'] ?? '') ?></div>
                            </td>
                            <td><?= htmlspecialchars($s['sujet']) ?></td>
                            <td class="hide-mobile">
                                <span class="col-name"><?= htmlspecialchars($s['entreprise_nom']) ?></span>
                                <div class="sub"><?= htmlspecialchars($s['ville'] ?? '') ?></div>
                            </td>
                            <td class="hide-mobile text-nowrap text-muted small">
                                <?= date('d/m/Y', strtotime($s['dateDebut'])) ?>
                                &rarr;
                                <?= date('d/m/Y', strtotime($s['dateFin'])) ?>
                            </td>
                            <td class="text-center hide-mobile">
                                <span class="badge bg-secondary">/<?= $s['bareme'] ?></span>
                            </td>
                            <td class="text-center">
                                <?php if ($s['statut'] === 'actif'): ?>
                                    <span class="badge bg-success">Actif</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary"><?= ucfirst($s['statut']) ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end text-nowrap">
                                <div class="dropdown-menu-container">
                                    <button class="dropdown-menu-trigger" title="Actions">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu-content">
                                        <li><a href="index.php?controller=evaluation&action=saisie&stage=<?= $s['numero_stage'] ?>" class="dropdown-menu-item">
                                            <i class="bi bi-pencil-square"></i> Évaluer
                                        </a></li>
                                        <li><a href="index.php?controller=evaluation&action=fiche&stage=<?= $s['numero_stage'] ?>" class="dropdown-menu-item">
                                            <i class="bi bi-clipboard-data"></i> Fiche
                                        </a></li>
                                        <li><a href="index.php?controller=stage&action=edit&id=<?= $s['numero_stage'] ?>" class="dropdown-menu-item">
                                            <i class="bi bi-pencil"></i> Modifier
                                        </a></li>
                                        <li><a href="index.php?controller=stage&action=delete&id=<?= $s['numero_stage'] ?>" class="dropdown-menu-item danger" data-confirm="Supprimer ce stage et toutes ses évaluations ?">
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
