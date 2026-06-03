<?php
/**
 * Vue : Tableau de bord principal
 */
?>

<!-- Cartes de statistiques -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">👨‍🎓</div>
        <div>
            <div class="stat-value"><?= $stats['nb_stagiaires'] ?></div>
            <div class="stat-label">Stagiaires</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">🏢</div>
        <div>
            <div class="stat-value"><?= $stats['nb_entreprises'] ?></div>
            <div class="stat-label">Entreprises</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">📋</div>
        <div>
            <div class="stat-value"><?= $stats['nb_stages'] ?></div>
            <div class="stat-label">Stages</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">⚖️</div>
        <div>
            <div class="stat-value"><?= $stats['nb_criteres'] ?></div>
            <div class="stat-label">Critères</div>
        </div>
    </div>
</div>

<!-- Top 5 classement -->
<div class="card">
    <div class="card-header">
        <h2>🏆 Top 5 — Classement par note finale</h2>
        <a href="<?= BASE_URL ?>?controller=stagiaire&action=classement" class="btn btn-accent btn-sm">
            Voir tout
        </a>
    </div>
    <div class="card-body">
        <?php if (empty($classement)): ?>
            <p style="color:var(--text-muted); text-align:center; padding:20px 0;">
                Aucune évaluation enregistrée pour le moment.
            </p>
        <?php else: ?>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Stagiaire</th>
                            <th>École</th>
                            <th>Entreprise</th>
                            <th>Note finale</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($classement as $i => $row): ?>
                            <?php
                            $medals = ['🥇', '🥈', '🥉'];
                            $medal  = $medals[$i] ?? ($i + 1);
                            ?>
                            <tr class="rank-<?= $i + 1 ?>">
                                <td><span class="medal"><?= $medal ?></span></td>
                                <td><strong><?= htmlspecialchars($row['nom'] . ' ' . $row['prenom']) ?></strong></td>
                                <td><?= htmlspecialchars($row['ecole']) ?></td>
                                <td><?= htmlspecialchars($row['entreprise']) ?></td>
                                <td>
                                    <span class="badge badge-success">
                                        <?= $row['note_finale'] ?? 'N/A' ?> / 20
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