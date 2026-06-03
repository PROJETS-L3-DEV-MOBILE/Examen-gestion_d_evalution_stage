<?php /** Vue : Liste des critères d'évaluation */ ?>

<div class="card">
    <div class="card-header">
        <h2>⚖️ Critères d'évaluation</h2>
        <a href="<?= BASE_URL ?>?controller=critere&action=create" class="btn btn-accent btn-sm">
            + Nouveau critère
        </a>
    </div>
    <div class="card-body">
        <?php if (empty($criteres)): ?>
            <div class="alert alert-info">
                Aucun critère défini. <a href="<?= BASE_URL ?>?controller=critere&action=create">Ajouter le premier critère</a>.
            </div>
        <?php else: ?>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Libellé du critère</th>
                            <th>Coefficient</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($criteres as $c): ?>
                            <tr>
                                <td><?= $c['id_critere'] ?></td>
                                <td><strong><?= htmlspecialchars($c['libelle_critere']) ?></strong></td>
                                <td>
                                    <span class="badge badge-accent">× <?= $c['coefficient'] ?></span>
                                </td>
                                <td>
                                    <div class="actions">
                                        <a href="<?= BASE_URL ?>?controller=critere&action=edit&id=<?= $c['id_critere'] ?>"
                                           class="btn btn-outline btn-sm">✏️ Modifier</a>
                                        <form method="POST"
                                              action="<?= BASE_URL ?>?controller=critere&action=delete&id=<?= $c['id_critere'] ?>"
                                              onsubmit="return confirm('Supprimer ce critère ?')">
                                            <button type="submit" class="btn btn-danger btn-sm">🗑️</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>