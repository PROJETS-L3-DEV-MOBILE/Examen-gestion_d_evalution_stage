<?php /** Vue : Liste des stages */ ?>

<div class="card">
    <div class="card-header">
        <h2>📋 Liste des stages</h2>
        <a href="<?= BASE_URL ?>?controller=stage&action=create" class="btn btn-accent btn-sm">
            + Attribuer un stage
        </a>
    </div>
    <div class="card-body">
        <?php if (empty($stages)): ?>
            <div class="alert alert-info">
                Aucun stage enregistré. <a href="<?= BASE_URL ?>?controller=stage&action=create">Attribuer le premier stage</a>.
            </div>
        <?php else: ?>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Stagiaire</th>
                            <th>Entreprise</th>
                            <th>Sujet</th>
                            <th>Début</th>
                            <th>Fin</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($stages as $s): ?>
                            <?php
                            // Détermine si le stage est actif (en cours)
                            $today = date('Y-m-d');
                            $actif = ($s['dateDebut'] <= $today && $s['dateFin'] >= $today);
                            ?>
                            <tr>
                                <td><?= $s['numero_stage'] ?></td>
                                <td>
                                    <strong><?= htmlspecialchars($s['stagiaire_nom'] . ' ' . $s['stagiaire_prenom']) ?></strong>
                                </td>
                                <td><?= htmlspecialchars($s['entreprise_nom']) ?></td>
                                <td><?= htmlspecialchars($s['sujet']) ?></td>
                                <td><?= date('d/m/Y', strtotime($s['dateDebut'])) ?></td>
                                <td><?= date('d/m/Y', strtotime($s['dateFin'])) ?></td>
                                <td>
                                    <div class="actions">
                                        <!-- Lien vers les évaluations du stage -->
                                        <a href="<?= BASE_URL ?>?controller=evaluation&action=index&stage_id=<?= $s['numero_stage'] ?>"
                                           class="btn btn-success btn-sm">⭐ Évaluations</a>
                                        <a href="<?= BASE_URL ?>?controller=stage&action=edit&id=<?= $s['numero_stage'] ?>"
                                           class="btn btn-outline btn-sm">✏️</a>
                                        <form method="POST"
                                              action="<?= BASE_URL ?>?controller=stage&action=delete&id=<?= $s['numero_stage'] ?>"
                                              onsubmit="return confirm('Supprimer ce stage et toutes ses évaluations ?')">
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