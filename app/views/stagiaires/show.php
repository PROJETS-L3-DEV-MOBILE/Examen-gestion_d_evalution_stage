<div class="d-flex align-items-center mb-4">
    <a href="index.php?controller=stagiaire&action=index" class="btn btn-sm btn-outline-secondary me-3">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h1 class="h3 mb-0">
        <i class="bi bi-person-circle text-primary me-2"></i>
        <?= htmlspecialchars($stagiaire['prenom'] . ' ' . $stagiaire['nom']) ?>
    </h1>
</div>

<div class="row g-4">
    <!-- Informations du stagiaire -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-primary text-white py-3">
                <h5 class="mb-0"><i class="bi bi-person-badge me-2"></i>Informations</h5>
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-5 text-muted">Nom</dt>
                    <dd class="col-7"><?= htmlspecialchars($stagiaire['nom']) ?></dd>

                    <dt class="col-5 text-muted">Prenom</dt>
                    <dd class="col-7"><?= htmlspecialchars($stagiaire['prenom']) ?></dd>

                    <dt class="col-5 text-muted">Email</dt>
                    <dd class="col-7"><?= htmlspecialchars($stagiaire['email'] ?? '-') ?></dd>

                    <dt class="col-5 text-muted">Ecole</dt>
                    <dd class="col-7"><?= htmlspecialchars($stagiaire['ecole'] ?? '-') ?></dd>

                    <dt class="col-5 text-muted">Filiere</dt>
                    <dd class="col-7"><?= htmlspecialchars($stagiaire['filiere'] ?? '-') ?></dd>
                </dl>
            </div>
            <div class="card-footer bg-white border-top d-flex gap-2">
                <a href="index.php?controller=stagiaire&action=edit&id=<?= $stagiaire['numero_stagiaire'] ?>"
                   class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-pencil me-1"></i>Modifier
                </a>
            </div>
        </div>
    </div>

    <!-- Stages du stagiaire -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0"><i class="bi bi-briefcase text-secondary me-2"></i>Stages</h5>
                <a href="index.php?controller=stage&action=create" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-plus-lg me-1"></i>Nouveau stage
                </a>
            </div>
            <div class="card-body p-0">
                <?php if (empty($stages)): ?>
                    <p class="text-center text-muted py-4">Aucun stage pour ce stagiaire.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Sujet</th>
                                    <th>Entreprise</th>
                                    <th>Periode</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($stages as $st): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($st['sujet']) ?></td>
                                        <td><?= htmlspecialchars($st['entreprise_nom']) ?></td>
                                        <td class="text-nowrap small">
                                            <?= date('d/m/Y', strtotime($st['dateDebut'])) ?>
                                            &rarr;
                                            <?= date('d/m/Y', strtotime($st['dateFin'])) ?>
                                        </td>
                                        <td>
                                            <span class="badge <?= $st['statut'] === 'actif' ? 'bg-success' : 'bg-secondary' ?>">
                                                <?= ucfirst($st['statut']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="index.php?controller=evaluation&action=fiche&stage=<?= $st['numero_stage'] ?>"
                                               class="btn btn-sm btn-outline-info">
                                                <i class="bi bi-clipboard-data"></i>
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
    </div>
</div>
