<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0"><i class="bi bi-building-fill text-success me-2"></i>Entreprises</h1>
    <a href="index.php?controller=entreprise&action=create" class="btn btn-success">
        <i class="bi bi-plus-lg me-1"></i>Nouvelle entreprise
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <?php if (empty($entreprises)): ?>
            <p class="text-center text-muted py-5">Aucune entreprise enregistree.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Secteur d'activite</th>
                            <th>Ville</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($entreprises as $e): ?>
                            <tr>
                                <td class="text-muted small"><?= $e['numero_entreprise'] ?></td>
                                <td class="fw-semibold"><?= htmlspecialchars($e['nom']) ?></td>
                                <td><?= htmlspecialchars($e['secteur_activite'] ?? '') ?></td>
                                <td><?= htmlspecialchars($e['ville'] ?? '') ?></td>
                                <td class="text-end text-nowrap">
                                    <a href="index.php?controller=entreprise&action=edit&id=<?= $e['numero_entreprise'] ?>"
                                       class="btn btn-sm btn-outline-primary me-1" title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="index.php?controller=entreprise&action=delete&id=<?= $e['numero_entreprise'] ?>"
                                       class="btn btn-sm btn-outline-danger"
                                       title="Supprimer"
                                       onclick="return confirm('Supprimer cette entreprise ?')">
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
