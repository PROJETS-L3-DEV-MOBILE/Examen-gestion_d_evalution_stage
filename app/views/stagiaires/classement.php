<?php /** Vue : Classement des stagiaires par note finale */ ?>

<div class="card">
    <div class="card-header">
        <h2>🏆 Classement général — Note finale décroissante</h2>
    </div>
    <div class="card-body">
        <?php if (empty($classement)): ?>
            <div class="alert alert-info">
                Aucune donnée de classement disponible. Ajoutez des évaluations pour les stages.
            </div>
        <?php else: ?>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Rang</th>
                            <th>Stagiaire</th>
                            <th>École</th>
                            <th>Filière</th>
                            <th>Sujet du stage</th>
                            <th>Entreprise</th>
                            <th>Note finale / 20</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($classement as $i => $row): ?>
                            <?php
                            // Attribution des médailles pour les 3 premiers
                            $medals = ['🥇', '🥈', '🥉'];
                            $rang   = $i + 1;
                            $medal  = $medals[$i] ?? "#$rang";

                            // Couleur de la note selon le résultat
                            $note  = $row['note_finale'];
                            $class = $note >= 14 ? 'badge-success' : ($note >= 10 ? 'badge-warning' : 'badge-danger');
                            ?>
                            <tr class="rank-<?= min($rang, 3) ?>">
                                <td style="text-align:center; font-size:18px;"><?= $medal ?></td>
                                <td>
                                    <strong><?= htmlspecialchars($row['nom'] . ' ' . $row['prenom']) ?></strong>
                                </td>
                                <td><?= htmlspecialchars($row['ecole']) ?></td>
                                <td><span class="badge badge-primary"><?= htmlspecialchars($row['filiere']) ?></span></td>
                                <td><?= htmlspecialchars($row['sujet']) ?></td>
                                <td><?= htmlspecialchars($row['entreprise']) ?></td>
                                <td>
                                    <span class="badge <?= $class ?>" style="font-size:14px; padding:5px 14px;">
                                        <?= $note !== null ? $note : 'N/A' ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>