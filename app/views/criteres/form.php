<?php
$isEdit = !empty($critere['id_critere']);
$action = $isEdit ? 'update' : 'store';
?>

<div class="card" style="max-width: 550px; margin: 0 auto;">
    <div class="card-header">
        <h2><?= $isEdit ? '✏️ Modifier le critère' : '➕ Nouveau critère d\'évaluation' ?></h2>
    </div>
    <div class="card-body">

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <div><strong>❌ Erreurs :</strong>
                    <ul><?php foreach ($errors as $err): ?><li><?= htmlspecialchars($err) ?></li><?php endforeach; ?></ul>
                </div>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?= BASE_URL ?>?controller=critere&action=<?= $action ?>">
            <?php if ($isEdit): ?>
                <input type="hidden" name="id" value="<?= $critere['id_critere'] ?>">
            <?php endif; ?>

            <div class="form-grid">
                <div class="form-group full">
                    <label for="libelle_critere">Libellé du critère <span style="color:red">*</span></label>
                    <input type="text" id="libelle_critere" name="libelle_critere"
                           value="<?= htmlspecialchars($critere['libelle_critere'] ?? '') ?>"
                           placeholder="Ex: Qualité du travail, Ponctualité..." required>
                </div>

                <div class="form-group full">
                    <label for="coefficient">Coefficient <span style="color:red">*</span></label>
                    <input type="number" id="coefficient" name="coefficient"
                           value="<?= htmlspecialchars($critere['coefficient'] ?? '') ?>"
                           min="0" step="0.5"
                           placeholder="Ex: 2, 3, 1.5..." required>
                    <small style="color:var(--text-muted);">
                        ⚠️ Le coefficient ne peut pas être négatif.
                    </small>
                </div>
            </div>

            <div class="form-actions">
                <a href="<?= BASE_URL ?>?controller=critere&action=index" class="btn btn-outline">← Annuler</a>
                <button type="submit" class="btn btn-primary">
                    <?= $isEdit ? '💾 Enregistrer' : '✅ Créer le critère' ?>
                </button>
            </div>
        </form>
    </div>
</div>