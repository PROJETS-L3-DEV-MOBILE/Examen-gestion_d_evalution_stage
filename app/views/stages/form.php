<?php
$isEdit = $action === 'update';
$title  = $isEdit ? 'Modifier le stage' : 'Attribuer un stage';
$id     = $stage['numero_stage'] ?? '';
?>

<div class="d-flex align-items-center mb-4">
    <a href="index.php?controller=stage&action=index" class="btn btn-sm btn-outline-secondary me-3">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h1 class="h3 mb-0"><i class="bi bi-briefcase text-warning me-2"></i><?= $title ?></h1>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">

                <?php if (!empty($errors['general'])): ?>
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <?= htmlspecialchars($errors['general']) ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="index.php?controller=stage&action=<?= $action ?>">
                    <?php if ($isEdit): ?>
                        <input type="hidden" name="id" value="<?= $id ?>">
                    <?php endif; ?>

                    <div class="row g-3">
                        <!-- Stagiaire -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" for="numero_stagiaire">
                                Stagiaire <span class="text-danger">*</span>
                            </label>
                            <select id="numero_stagiaire" name="numero_stagiaire"
                                    class="form-select <?= !empty($errors['numero_stagiaire']) ? 'is-invalid' : '' ?>" required>
                                <option value="">-- Selectionner --</option>
                                <?php foreach ($stagiaires as $st): ?>
                                    <option value="<?= $st['numero_stagiaire'] ?>"
                                        <?= ($stage['numero_stagiaire'] ?? '') == $st['numero_stagiaire'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($st['prenom'] . ' ' . $st['nom']) ?>
                                        (<?= htmlspecialchars($st['ecole'] ?? '') ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (!empty($errors['numero_stagiaire'])): ?>
                                <div class="invalid-feedback"><?= htmlspecialchars($errors['numero_stagiaire']) ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Entreprise -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" for="numero_entreprise">
                                Entreprise <span class="text-danger">*</span>
                            </label>
                            <select id="numero_entreprise" name="numero_entreprise"
                                    class="form-select <?= !empty($errors['numero_entreprise']) ? 'is-invalid' : '' ?>" required>
                                <option value="">-- Selectionner --</option>
                                <?php foreach ($entreprises as $e): ?>
                                    <option value="<?= $e['numero_entreprise'] ?>"
                                        <?= ($stage['numero_entreprise'] ?? '') == $e['numero_entreprise'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($e['nom']) ?>
                                        (<?= htmlspecialchars($e['ville'] ?? '') ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (!empty($errors['numero_entreprise'])): ?>
                                <div class="invalid-feedback"><?= htmlspecialchars($errors['numero_entreprise']) ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Sujet -->
                        <div class="col-12">
                            <label class="form-label fw-semibold" for="sujet">
                                Sujet du stage <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="sujet" name="sujet"
                                   class="form-control <?= !empty($errors['sujet']) ? 'is-invalid' : '' ?>"
                                   value="<?= htmlspecialchars($stage['sujet'] ?? '') ?>" required>
                            <?php if (!empty($errors['sujet'])): ?>
                                <div class="invalid-feedback"><?= htmlspecialchars($errors['sujet']) ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Date debut -->
                        <div class="col-md-4">
                            <label class="form-label fw-semibold" for="dateDebut">
                                Date de debut <span class="text-danger">*</span>
                            </label>
                            <input type="date" id="dateDebut" name="dateDebut"
                                   class="form-control <?= !empty($errors['dateDebut']) ? 'is-invalid' : '' ?>"
                                   value="<?= htmlspecialchars($stage['dateDebut'] ?? '') ?>" required>
                            <?php if (!empty($errors['dateDebut'])): ?>
                                <div class="invalid-feedback"><?= htmlspecialchars($errors['dateDebut']) ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Date fin -->
                        <div class="col-md-4">
                            <label class="form-label fw-semibold" for="dateFin">
                                Date de fin <span class="text-danger">*</span>
                            </label>
                            <input type="date" id="dateFin" name="dateFin"
                                   class="form-control <?= !empty($errors['dateFin']) ? 'is-invalid' : '' ?>"
                                   value="<?= htmlspecialchars($stage['dateFin'] ?? '') ?>" required>
                            <?php if (!empty($errors['dateFin'])): ?>
                                <div class="invalid-feedback"><?= htmlspecialchars($errors['dateFin']) ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Bareme -->
                        <div class="col-md-2">
                            <label class="form-label fw-semibold" for="bareme">Bareme</label>
                            <select id="bareme" name="bareme" class="form-select">
                                <option value="20" <?= ($stage['bareme'] ?? 20) == 20 ? 'selected' : '' ?>>/20</option>
                                <option value="10" <?= ($stage['bareme'] ?? 20) == 10 ? 'selected' : '' ?>>/10</option>
                            </select>
                        </div>

                        <!-- Statut (uniquement en mode edition) -->
                        <?php if ($isEdit): ?>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold" for="statut">Statut</label>
                            <select id="statut" name="statut" class="form-select">
                                <option value="actif"   <?= ($stage['statut'] ?? 'actif') === 'actif'   ? 'selected' : '' ?>>Actif</option>
                                <option value="termine" <?= ($stage['statut'] ?? '') === 'termine' ? 'selected' : '' ?>>Termine</option>
                            </select>
                        </div>
                        <?php endif; ?>

                        <!-- Boutons -->
                        <div class="col-12 d-flex justify-content-end gap-2 mt-3">
                            <a href="index.php?controller=stage&action=index" class="btn btn-secondary">Annuler</a>
                            <button type="submit" class="btn btn-warning text-dark">
                                <i class="bi bi-save me-1"></i><?= $isEdit ? 'Mettre a jour' : 'Attribuer' ?>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
