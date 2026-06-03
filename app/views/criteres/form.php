<?php
$isEdit = $action === 'update';
$title  = $isEdit ? 'Modifier le critere' : 'Nouveau critere';
$id     = $critere['id_critere'] ?? '';
?>

<div class="d-flex align-items-center mb-4">
    <a href="index.php?controller=critere&action=index" class="btn btn-sm btn-outline-secondary me-3">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h1 class="h3 mb-0"><i class="bi bi-list-check text-info me-2"></i><?= $title ?></h1>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form method="POST" action="index.php?controller=critere&action=<?= $action ?>">
                    <?php if ($isEdit): ?>
                        <input type="hidden" name="id" value="<?= $id ?>">
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="libelle_critere">
                            Libelle du critere <span class="text-danger">*</span>
                        </label>
                        <input type="text" id="libelle_critere" name="libelle_critere"
                               class="form-control <?= !empty($errors['libelle_critere']) ? 'is-invalid' : '' ?>"
                               value="<?= htmlspecialchars($critere['libelle_critere'] ?? '') ?>" required>
                        <?php if (!empty($errors['libelle_critere'])): ?>
                            <div class="invalid-feedback"><?= htmlspecialchars($errors['libelle_critere']) ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="coefficient">
                            Coefficient <span class="text-danger">*</span>
                        </label>
                        <input type="number" id="coefficient" name="coefficient" step="0.01" min="0"
                               class="form-control <?= !empty($errors['coefficient']) ? 'is-invalid' : '' ?>"
                               value="<?= htmlspecialchars($critere['coefficient'] ?? '1') ?>" required>
                        <div class="form-text">Le coefficient doit etre un nombre positif ou nul.</div>
                        <?php if (!empty($errors['coefficient'])): ?>
                            <div class="invalid-feedback"><?= htmlspecialchars($errors['coefficient']) ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="index.php?controller=critere&action=index" class="btn btn-secondary">Annuler</a>
                        <button type="submit" class="btn btn-info text-white">
                            <i class="bi bi-save me-1"></i><?= $isEdit ? 'Mettre a jour' : 'Enregistrer' ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
