<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0"><i class="bi bi-person-badge-fill text-primary me-2"></i>Stagiaires</h1>
    <a href="index.php?controller=stagiaire&action=create" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Nouveau stagiaire
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <?php if (empty($stagiaires)): ?>
            <p class="text-center text-muted py-5">Aucun stagiaire enregistré.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nom &amp; Prenom</th>
                            <th>Email</th>
                            <th>Ecole</th>
                            <th>Filiere</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($stagiaires as $s): ?>
                            <tr>
                                <td class="text-muted small"><?= $s['numero_stagiaire'] ?></td>
                                <td class="fw-semibold">
                                    <?= htmlspecialchars($s['prenom'] . ' ' . $s['nom']) ?>
                                </td>
                                <td><?= htmlspecialchars($s['email'] ?? '') ?></td>
                                <td><?= htmlspecialchars($s['ecole'] ?? '') ?></td>
                                <td><?= htmlspecialchars($s['filiere'] ?? '') ?></td>
                                <td class="text-end text-nowrap">
                                    <a href="index.php?controller=stagiaire&action=show&id=<?= $s['numero_stagiaire'] ?>"
                                       class="btn btn-sm btn-outline-secondary me-1" title="Voir">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="index.php?controller=stagiaire&action=edit&id=<?= $s['numero_stagiaire'] ?>"
                                       class="btn btn-sm btn-outline-primary me-1" title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="index.php?controller=stagiaire&action=delete&id=<?= $s['numero_stagiaire'] ?>"
                                       class="btn btn-sm btn-outline-danger"
                                       title="Supprimer"
                                       onclick="return confirm('Supprimer ce stagiaire ?')">
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
