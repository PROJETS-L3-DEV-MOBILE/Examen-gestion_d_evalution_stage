<?php
$isEdit = $action === 'update';
$title  = $isEdit ? 'Modifier l\'entreprise' : 'Nouvelle entreprise';
$id     = $entreprise['numero_entreprise'] ?? '';
?>

<div class="d-flex align-items-center mb-4">
    <a href="index.php?controller=entreprise&action=index" class="btn btn-sm btn-outline-secondary me-3">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h1 class="h3 mb-0"><i class="bi bi-building text-success me-2"></i><?= $title ?></h1>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form method="POST" action="index.php?controller=entreprise&action=<?= $action ?>">
                    <?php if ($isEdit): ?>
                        <input type="hidden" name="id" value="<?= $id ?>">
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="nom">Nom <span class="text-danger">*</span></label>
                        <input type="text" id="nom" name="nom"
                               class="form-control <?= !empty($errors['nom']) ? 'is-invalid' : '' ?>"
                               value="<?= htmlspecialchars($entreprise['nom'] ?? '') ?>" required>
                        <?php if (!empty($errors['nom'])): ?>
                            <div class="invalid-feedback"><?= htmlspecialchars($errors['nom']) ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="secteur_activite">Secteur d'activite</label>
                        <input type="text" id="secteur_activite" name="secteur_activite" class="form-control"
                               value="<?= htmlspecialchars($entreprise['secteur_activite'] ?? '') ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="ville">Ville</label>
                        <input type="text" id="ville" name="ville" class="form-control"
                               value="<?= htmlspecialchars($entreprise['ville'] ?? '') ?>">
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="index.php?controller=entreprise&action=index" class="btn btn-secondary">Annuler</a>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-save me-1"></i><?= $isEdit ? 'Mettre a jour' : 'Enregistrer' ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
