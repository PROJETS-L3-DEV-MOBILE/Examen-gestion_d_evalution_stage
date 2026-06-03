<?php /** Vue : Liste des entreprises */ ?>

<div class="card">
    <div class="card-header">
        <h2>🏢 Liste des entreprises</h2>
        <a href="<?= BASE_URL ?>?controller=entreprise&action=create" class="btn btn-accent btn-sm">
            + Nouvelle entreprise
        </a>
    </div>
    <div class="card-body">
        <?php if (empty($entreprises)): ?>
            <div class="alert alert-info">
                Aucune entreprise enregistrée. <a href="<?= BASE_URL ?>?controller=entreprise&action=create">Ajouter la première</a>.
            </div>
        <?php else: ?>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Secteur d'activité</th>
                            <th>Ville</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($entreprises as $e): ?>
                            <tr>
                                <td><?= $e['numero_entreprise'] ?></td>
                                <td><strong><?= htmlspecialchars($e['nom']) ?></strong></td>
                                <td><span class="badge badge-accent"><?= htmlspecialchars($e['secteur_activite']) ?></span></td>
                                <td>📍 <?= htmlspecialchars($e['ville']) ?></td>
                                <td>
                                    <div class="actions">
                                        <a href="<?= BASE_URL ?>?controller=entreprise&action=edit&id=<?= $e['numero_entreprise'] ?>"
                                           class="btn btn-outline btn-sm">✏️ Modifier</a>
                                        <form method="POST"
                                              action="<?= BASE_URL ?>?controller=entreprise&action=delete&id=<?= $e['numero_entreprise'] ?>"
                                              onsubmit="return confirm('Supprimer cette entreprise ?')">
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