<?php /** Vue : Liste des stagiaires */ ?>

<div class="card">
    <div class="card-header">
        <h2>👨‍🎓 Liste des stagiaires</h2>
        <a href="<?= BASE_URL ?>?controller=stagiaire&action=create" class="btn btn-accent btn-sm">
            + Nouveau stagiaire
        </a>
    </div>
    <div class="card-body">
        <?php if (empty($stagiaires)): ?>
            <div class="alert alert-info">
                Aucun stagiaire enregistré. <a href="<?= BASE_URL ?>?controller=stagiaire&action=create">Ajouter le premier</a>.
            </div>
        <?php else: ?>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>École</th>
                            <th>Filière</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($stagiaires as $s): ?>
                            <tr>
                                <td><?= $s['numero_stagiaire'] ?></td>
                                <td><strong><?= htmlspecialchars($s['nom']) ?></strong></td>
                                <td><?= htmlspecialchars($s['prenom']) ?></td>
                                <td><?= htmlspecialchars($s['email']) ?></td>
                                <td><?= htmlspecialchars($s['ecole']) ?></td>
                                <td><span class="badge badge-primary"><?= htmlspecialchars($s['filiere']) ?></span></td>
                                <td>
                                    <div class="actions">
                                        <a href="<?= BASE_URL ?>?controller=stagiaire&action=edit&id=<?= $s['numero_stagiaire'] ?>"
                                           class="btn btn-outline btn-sm">✏️ Modifier</a>
                                        <!-- Formulaire de suppression sécurisé via POST -->
                                        <form method="POST"
                                              action="<?= BASE_URL ?>?controller=stagiaire&action=delete&id=<?= $s['numero_stagiaire'] ?>"
                                              onsubmit="return confirm('Supprimer ce stagiaire ?')">
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