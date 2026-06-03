<?php
$isEdit = !empty($stage['numero_stage']);
$action = $isEdit ? 'update' : 'store';
?>

<div class="card" style="max-width: 720px; margin: 0 auto;">
    <div class="card-header">
        <h2><?= $isEdit ? '✏️ Modifier le stage' : '➕ Attribuer un stage' ?></h2>
    </div>
    <div class="card-body">

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <div><strong>❌ Erreurs :</strong>
                    <ul><?php foreach ($errors as $err): ?><li><?= htmlspecialchars($err) ?></li><?php endforeach; ?></ul>
                </div>
            </div>
        <?php endif; ?>

        <!-- Note informative sur la règle d'un seul stage actif -->
        <div class="alert alert-info" style="margin-bottom:20px;">
            ℹ️ <strong>Règle :</strong> Un stagiaire ne peut avoir qu'un seul stage actif à la fois.
            La date de début doit être antérieure à la date de fin.
        </div>

        <form method="POST" action="<?= BASE_URL ?>?controller=stage&action=<?= $action ?>">
            <?php if ($isEdit): ?>
                <input type="hidden" name="id" value="<?= $stage['numero_stage'] ?>">
            <?php endif; ?>

            <div class="form-grid">
                <!-- Sélection du stagiaire -->
                <div class="form-group">
                    <label for="numero_stagiaire">Stagiaire <span style="color:red">*</span></label>
                    <select id="numero_stagiaire" name="numero_stagiaire" required>
                        <option value="">— Sélectionner —</option>
                        <?php foreach ($stagiaires as $s): ?>
                            <option value="<?= $s['numero_stagiaire'] ?>"
                                <?= ($stage['numero_stagiaire'] ?? '') == $s['numero_stagiaire'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($s['nom'] . ' ' . $s['prenom']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Sélection de l'entreprise -->
                <div class="form-group">
                    <label for="numero_entreprise">Entreprise <span style="color:red">*</span></label>
                    <select id="numero_entreprise" name="numero_entreprise" required>
                        <option value="">— Sélectionner —</option>
                        <?php foreach ($entreprises as $e): ?>
                            <option value="<?= $e['numero_entreprise'] ?>"
                                <?= ($stage['numero_entreprise'] ?? '') == $e['numero_entreprise'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($e['nom']) ?> — <?= htmlspecialchars($e['ville']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Sujet du stage -->
                <div class="form-group full">
                    <label for="sujet">Sujet du stage <span style="color:red">*</span></label>
                    <input type="text" id="sujet" name="sujet"
                           value="<?= htmlspecialchars($stage['sujet'] ?? '') ?>"
                           placeholder="Ex: Développement d'une application web de gestion..." required>
                </div>

                <!-- Date de début -->
                <div class="form-group">
                    <label for="dateDebut">Date de début <span style="color:red">*</span></label>
                    <input type="date" id="dateDebut" name="dateDebut"
                           value="<?= htmlspecialchars($stage['dateDebut'] ?? '') ?>" required>
                </div>

                <!-- Date de fin -->
                <div class="form-group">
                    <label for="dateFin">Date de fin <span style="color:red">*</span></label>
                    <input type="date" id="dateFin" name="dateFin"
                           value="<?= htmlspecialchars($stage['dateFin'] ?? '') ?>" required>
                </div>
            </div>

            <div class="form-actions">
                <a href="<?= BASE_URL ?>?controller=stage&action=index" class="btn btn-outline">← Annuler</a>
                <button type="submit" class="btn btn-primary">
                    <?= $isEdit ? '💾 Enregistrer' : '✅ Attribuer le stage' ?>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
/* Validation côté client : dateDebut < dateFin */
document.querySelector('form').addEventListener('submit', function(e) {
    const debut = document.getElementById('dateDebut').value;
    const fin   = document.getElementById('dateFin').value;
    if (debut && fin && debut >= fin) {
        e.preventDefault();
        alert('La date de début doit être antérieure à la date de fin.');
    }
});
</script>