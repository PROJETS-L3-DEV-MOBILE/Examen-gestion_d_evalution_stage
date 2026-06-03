<?php
$isEdit = !empty($entreprise['numero_entreprise']);
$action = $isEdit ? 'update' : 'store';
?>

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <div class="card-header">
        <h2><?= $isEdit ? '✏️ Modifier l\'entreprise' : '➕ Nouvelle entreprise' ?></h2>
    </div>
    <div class="card-body">

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <div><strong>❌ Erreurs :</strong>
                    <ul><?php foreach ($errors as $err): ?><li><?= htmlspecialchars($err) ?></li><?php endforeach; ?></ul>
                </div>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?= BASE_URL ?>?controller=entreprise&action=<?= $action ?>">
            <?php if ($isEdit): ?>
                <input type="hidden" name="id" value="<?= $entreprise['numero_entreprise'] ?>">
            <?php endif; ?>

            <div class="form-grid">
                <div class="form-group full">
                    <label for="nom">Nom de l'entreprise <span style="color:red">*</span></label>
                    <input type="text" id="nom" name="nom"
                           value="<?= htmlspecialchars($entreprise['nom'] ?? '') ?>"
                           placeholder="Ex: Tech Solutions SARL" required>
                </div>

                <div class="form-group">
                    <label for="secteur_activite">Secteur d'activité <span style="color:red">*</span></label>
                    <input type="text" id="secteur_activite" name="secteur_activite"
                           value="<?= htmlspecialchars($entreprise['secteur_activite'] ?? '') ?>"
                           placeholder="Ex: Informatique, Finance..." required>
                </div>

                <div class="form-group">
                    <label for="ville">Ville <span style="color:red">*</span></label>
                    <input type="text" id="ville" name="ville"
                           value="<?= htmlspecialchars($entreprise['ville'] ?? '') ?>"
                           placeholder="Ex: Antananarivo" required>
                </div>
            </div>

            <div class="form-actions">
                <a href="<?= BASE_URL ?>?controller=entreprise&action=index" class="btn btn-outline">← Annuler</a>
                <button type="submit" class="btn btn-primary">
                    <?= $isEdit ? '💾 Enregistrer' : '✅ Créer' ?>
                </button>
            </div>
        </form>
    </div>
</div>