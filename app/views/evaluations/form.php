<?php
$isEdit = !empty($evaluation['numero_evaluation']);
$action = $isEdit ? 'update' : 'store';
$idStage = $stage['numero_stage'];
?>

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <div class="card-header">
        <h2><?= $isEdit ? '✏️ Modifier l\'évaluation' : '⭐ Nouvelle évaluation' ?></h2>
    </div>
    <div class="card-body">

        <!-- Infos du stage concerné -->
        <div class="alert alert-info" style="margin-bottom:20px;">
            📋 Stage : <strong><?= htmlspecialchars($stage['sujet'] ?? '') ?></strong>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <div><strong>❌ Erreurs :</strong>
                    <ul><?php foreach ($errors as $err): ?><li><?= htmlspecialchars($err) ?></li><?php endforeach; ?></ul>
                </div>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?= BASE_URL ?>?controller=evaluation&action=<?= $action ?>">
            <?php if ($isEdit): ?>
                <input type="hidden" name="id" value="<?= $evaluation['numero_evaluation'] ?>">
            <?php endif; ?>
            <!-- Toujours inclure l'ID du stage -->
            <input type="hidden" name="stage_id" value="<?= $idStage ?>">

            <div class="form-grid">
                <!-- Sélection du critère -->
                <div class="form-group full">
                    <label for="id_critere">Critère d'évaluation <span style="color:red">*</span></label>
                    <select id="id_critere" name="id_critere" required>
                        <option value="">— Sélectionner un critère —</option>
                        <?php foreach ($criteres as $c): ?>
                            <option value="<?= $c['id_critere'] ?>"
                                <?= ($evaluation['id_critere'] ?? '') == $c['id_critere'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($c['libelle_critere']) ?> (× <?= $c['coefficient'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Note -->
                <div class="form-group full">
                    <label for="note">Note <span style="color:red">*</span></label>
                    <input type="number" id="note" name="note"
                           value="<?= htmlspecialchars($evaluation['note'] ?? '') ?>"
                           min="0" max="20" step="0.5"
                           placeholder="Entre 0 et 20" required>
                    <small style="color:var(--text-muted);">Valeur entre 0 et 20.</small>
                </div>

                <!-- Observation -->
                <div class="form-group full">
                    <label for="observation">Observation</label>
                    <textarea id="observation" name="observation"
                              placeholder="Commentaire sur ce critère (optionnel)..."><?= htmlspecialchars($evaluation['observation'] ?? '') ?></textarea>
                </div>
            </div>

            <div class="form-actions">
                <a href="<?= BASE_URL ?>?controller=evaluation&action=index&stage_id=<?= $idStage ?>"
                   class="btn btn-outline">← Annuler</a>
                <button type="submit" class="btn btn-primary">
                    <?= $isEdit ? '💾 Enregistrer' : '✅ Ajouter l\'évaluation' ?>
                </button>
            </div>
        </form>
    </div>
</div>