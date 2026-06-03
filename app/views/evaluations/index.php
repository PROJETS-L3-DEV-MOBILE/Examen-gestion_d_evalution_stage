<?php /** Vue : Évaluations d'un stage */ ?>

<!-- En-tête du stage concerné -->
<div class="alert alert-info" style="margin-bottom:24px;">
    📋 <strong>Stage :</strong>
    <?= htmlspecialchars($stage['sujet'] ?? 'N/A') ?> —
    <strong><?= htmlspecialchars(($stage['stagiaire_nom'] ?? '') . ' ' . ($stage['stagiaire_prenom'] ?? '')) ?></strong>
    chez <em><?= htmlspecialchars($stage['entreprise_nom'] ?? '') ?></em>
    (<?= date('d/m/Y', strtotime($stage['dateDebut'])) ?> → <?= date('d/m/Y', strtotime($stage['dateFin'])) ?>)
</div>

<!-- Note finale calculée -->
<div class="note-finale-box">
    <div class="nf-label">NOTE FINALE CALCULÉE</div>
    <div class="nf-value">
        <?= $noteFinale !== null ? $noteFinale : '—' ?>
    </div>
    <div class="nf-max">
        <?= $noteFinale !== null ? '/ 20' : 'Coefficients nuls ou aucune évaluation' ?>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2>⭐ Évaluations par critère</h2>
        <div class="actions">
            <!-- Bouton d'ajout d'une évaluation -->
            <a href="<?= BASE_URL ?>?controller=evaluation&action=create&stage_id=<?= $stage['numero_stage'] ?>"
               class="btn btn-accent btn-sm">+ Ajouter</a>
            <!-- Bouton fiche individuelle -->
            <a href="<?= BASE_URL ?>?controller=evaluation&action=fiche&stage_id=<?= $stage['numero_stage'] ?>"
               class="btn btn-outline btn-sm">📄 Fiche</a>
            <!-- Bouton téléchargement PDF -->
            <a href="<?= BASE_URL ?>?controller=evaluation&action=pdf&stage_id=<?= $stage['numero_stage'] ?>"
               class="btn btn-primary btn-sm">⬇️ PDF</a>
        </div>
    </div>
    <div class="card-body">
        <?php if (empty($evaluations)): ?>
            <div class="alert alert-info">
                Aucune évaluation pour ce stage.
                <a href="<?= BASE_URL ?>?controller=evaluation&action=create&stage_id=<?= $stage['numero_stage'] ?>">
                    Ajouter la première évaluation
                </a>.
            </div>
        <?php else: ?>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Critère</th>
                            <th>Coefficient</th>
                            <th>Note / 20</th>
                            <th>Note pondérée</th>
                            <th>Observation</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($evaluations as $ev): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($ev['libelle_critere']) ?></strong></td>
                                <td><span class="badge badge-accent">× <?= $ev['coefficient'] ?></span></td>
                                <td>
                                    <?php
                                    $note = (float)$ev['note'];
                                    $cls  = $note >= 14 ? 'badge-success' : ($note >= 10 ? 'badge-warning' : 'badge-danger');
                                    ?>
                                    <span class="badge <?= $cls ?>"><?= $note ?> / 20</span>
                                </td>
                                <td>
                                    <!-- Note × coefficient (contribution au calcul) -->
                                    <span style="color:var(--text-muted); font-size:13px;">
                                        <?= round($note * $ev['coefficient'], 2) ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($ev['observation'] ?: '—') ?></td>
                                <td>
                                    <div class="actions">
                                        <a href="<?= BASE_URL ?>?controller=evaluation&action=edit&id=<?= $ev['numero_evaluation'] ?>"
                                           class="btn btn-outline btn-sm">✏️</a>
                                        <form method="POST"
                                              action="<?= BASE_URL ?>?controller=evaluation&action=delete&id=<?= $ev['numero_evaluation'] ?>"
                                              onsubmit="return confirm('Supprimer cette évaluation ?')">
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

<div style="margin-top:16px;">
    <a href="<?= BASE_URL ?>?controller=stage&action=index" class="btn btn-outline">← Retour aux stages</a>
</div>