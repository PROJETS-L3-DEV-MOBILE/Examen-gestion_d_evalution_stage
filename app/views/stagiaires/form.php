<?php
$isEdit = $action === 'update';
$title  = $isEdit ? 'Modifier le stagiaire' : 'Nouveau stagiaire';
$id     = $stagiaire['numero_stagiaire'] ?? '';
?>

<div class="d-flex align-items-center mb-4">
    <a href="index.php?controller=stagiaire&action=index" class="btn btn-sm btn-outline-secondary me-3">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h1 class="h3 mb-0"><i class="bi bi-person-badge text-primary me-2"></i><?= $title ?></h1>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">

                <?php if (!empty($errors['general'])): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($errors['general']) ?></div>
                <?php endif; ?>

                <form method="POST" action="index.php?controller=stagiaire&action=<?= $action ?>">
                    <?php if ($isEdit): ?>
                        <input type="hidden" name="id" value="<?= $id ?>">
                    <?php endif; ?>

                    <div class="row g-3">
                        <!-- Nom -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" for="nom">Nom <span class="text-danger">*</span></label>
                            <input type="text" id="nom" name="nom" class="form-control <?= !empty($errors['nom']) ? 'is-invalid' : '' ?>"
                                   value="<?= htmlspecialchars($stagiaire['nom'] ?? '') ?>" required>
                            <?php if (!empty($errors['nom'])): ?>
                                <div class="invalid-feedback"><?= htmlspecialchars($errors['nom']) ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Prenom -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" for="prenom">Prenom <span class="text-danger">*</span></label>
                            <input type="text" id="prenom" name="prenom" class="form-control <?= !empty($errors['prenom']) ? 'is-invalid' : '' ?>"
                                   value="<?= htmlspecialchars($stagiaire['prenom'] ?? '') ?>" required>
                            <?php if (!empty($errors['prenom'])): ?>
                                <div class="invalid-feedback"><?= htmlspecialchars($errors['prenom']) ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Email -->
                        <div class="col-12">
                            <label class="form-label fw-semibold" for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control <?= !empty($errors['email']) ? 'is-invalid' : '' ?>"
                                   value="<?= htmlspecialchars($stagiaire['email'] ?? '') ?>">
                            <?php if (!empty($errors['email'])): ?>
                                <div class="invalid-feedback"><?= htmlspecialchars($errors['email']) ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Ecole -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" for="ecole">Ecole</label>
                            <input type="text" id="ecole" name="ecole" class="form-control"
                                   value="<?= htmlspecialchars($stagiaire['ecole'] ?? '') ?>">
                        </div>

                        <!-- Filiere -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" for="filiere">Filiere</label>
                            <input type="text" id="filiere" name="filiere" class="form-control"
                                   value="<?= htmlspecialchars($stagiaire['filiere'] ?? '') ?>">
                        </div>

                        <!-- Boutons -->
                        <div class="col-12 d-flex justify-content-end gap-2 mt-3">
                            <a href="index.php?controller=stagiaire&action=index" class="btn btn-secondary">Annuler</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i><?= $isEdit ? 'Mettre a jour' : 'Enregistrer' ?>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
