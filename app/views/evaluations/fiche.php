<?php /** Vue : Fiche d'évaluation individuelle d'un stage */ ?>

<div class="card">
    <div class="card-header">
        <h2>📄 Fiche d'évaluation individuelle</h2>
        <a href="<?= BASE_URL ?>?controller=evaluation&action=pdf&stage_id=<?= $stage['numero_stage'] ?>"
           class="btn btn-accent btn-sm">⬇️ Télécharger PDF</a>
    </div>
    <div class="card-body">

        <!-- Informations générales du stage -->
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:28px;">
            <div>
                <p style="font-size:12px;color:var(--text-muted);margin-bottom:4px;">STAGIAIRE</p>
                <p style="font-weight:700;font-size:16px;">
                    <?= htmlspecialchars($stage['stagiaire_nom'] . ' ' . $stage['stagiaire_prenom']) ?>
                </p>
                <p style="color:var(--text-muted);">
                    <?= htmlspecialchars($stage['ecole']) ?> — <?= htmlspecialchars($stage['filiere']) ?>
                </p>
            </div>
            <div>
                <p style="font-size:12px;color:var(--text-muted);margin-bottom:4px;">ENTREPRISE</p>
                <p style="font-weight:700;font-size:16px;"><?= htmlspecialchars($stage['entreprise_nom']) ?></p>
                <p style="color:var(--text-muted);"><?= htmlspecialchars($stage['ville']) ?></p>
            </div>
            <div>
                <p style="font-size:12px;color:var(--text-muted);margin-bottom:4px;">SUJET</p>
                <p><?= htmlspecialchars($stage['sujet']) ?></p>
            </div>
            <div>
                <p style="font-size:12px;color:var(--text-muted);margin-bottom:4px;">PÉRIODE</p>
                <p>
                    <?= date('d/m/Y', strtotime($stage['dateDebut'])) ?>
                    → <?= date('d/m/Y', strtotime($stage['dateFin'])) ?>
                </p>
            </div>
        </div>

        <!-- Note finale -->
        <div class="note-finale-box" style="margin-bottom:28px;">
            <div class="nf-label">NOTE FINALE</div>
            <div class="nf-value"><?= $noteFinale !== null ? $noteFinale : '—' ?></div>
            <div class="nf-max">/ 20</div>
        </div>

        <!-- Tableau détaillé critère par critère -->
        <?php if (!empty($lignes)): ?>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Critère</th>
                            <th>Coefficient</th>
                            <th>Note / 20</th>
                            <th>Note × Coefficient</th>
                            <th>Observation</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lignes as $l): ?>
                            <tr>
                                <td><?= htmlspecialchars($l['libelle_critere']) ?></td>
                                <td><?= $l['coefficient'] ?></td>
                                <td><?= $l['note'] ?></td>
                                <td><?= round($l['note'] * $l['coefficient'], 2) ?></td>
                                <td><?= htmlspecialchars($l['observation'] ?: '—') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info">Aucune évaluation enregistrée pour ce stage.</div>
        <?php endif; ?>

    </div>
</div>

<div style="margin-top:16px; display:flex; gap:12px;">
    <a href="<?= BASE_URL ?>?controller=evaluation&action=index&stage_id=<?= $stage['numero_stage'] ?>"
       class="btn btn-outline">← Retour aux évaluations</a>
</div>