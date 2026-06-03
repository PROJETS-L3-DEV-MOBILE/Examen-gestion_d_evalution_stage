<?php
/**
 * Vue : Formulaire stagiaire (création et édition)
 * La variable $stagiaire est null pour la création, remplie pour l'édition.
 */
$isEdit = !empty($stagiaire['numero_stagiaire']);
$action = $isEdit ? 'update' : 'store';
?>

<div class="card" style="max-width: 700px; margin: 0 auto;">
    <div class="card-header">
        <h2><?= $isEdit ? '✏️ Modifier le stagiaire' : '➕ Nouveau stagiaire' ?></h2>
    </div>
    <div class="card-body">

        <!-- Affichage des erreurs de validation -->
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <div>
                    <strong>❌ Erreurs :</strong>
                    <ul>
                        <?php foreach ($errors as $err): ?>
                            <li><?= htmlspecialchars($err) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?= BASE_URL ?>?controller=stagiaire&action=<?= $action ?>">

            <!-- Champ caché pour l'ID en mode édition -->
            <?php if ($isEdit): ?>
                <input type="hidden" name="id" value="<?= $stagiaire['numero_stagiaire'] ?>">
            <?php endif; ?>

            <div class="form-grid">
                <!-- Nom -->
                <div class="form-group">
                    <label for="nom">Nom <span style="color:red">*</span></label>
                    <input type="text" id="nom" name="nom"
                           value="<?= htmlspecialchars($stagiaire['nom'] ?? '') ?>"
                           placeholder="Ex: Rakoto" required>
                </div>

                <!-- Prénom -->
                <div class="form-group">
                    <label for="prenom">Prénom <span style="color:red">*</span></label>
                    <input type="text" id="prenom" name="prenom"
                           value="<?= htmlspecialchars($stagiaire['prenom'] ?? '') ?>"
                           placeholder="Ex: Jean" required>
                </div>

                <!-- Email -->
                <div class="form-group full">
                    <label for="email">Adresse email <span style="color:red">*</span></label>
                    <input type="email" id="email" name="email"
                           value="<?= htmlspecialchars($stagiaire['email'] ?? '') ?>"
                           placeholder="Ex: jean.rakoto@email.mg" required>
                </div>

                <!-- École -->
                <div class="form-group">
                    <label for="ecole">École / Université <span style="color:red">*</span></label>
                    <input type="text" id="ecole" name="ecole"
                           value="<?= htmlspecialchars($stagiaire['ecole'] ?? '') ?>"
                           placeholder="Ex: ENI Antananarivo" required>
                </div>

                <!-- Filière -->
                <div class="form-group">
                    <label for="filiere">Filière <span style="color:red">*</span></label>
                    <input type="text" id="filiere" name="filiere"
                           value="<?= htmlspecialchars($stagiaire['filiere'] ?? '') ?>"
                           placeholder="Ex: Génie Informatique" required>
                </div>
            </div>

            <div class="form-actions">
                <a href="<?= BASE_URL ?>?controller=stagiaire&action=index" class="btn btn-outline">
                    ← Annuler
                </a>
                <button type="submit" class="btn btn-primary">
                    <?= $isEdit ? '💾 Enregistrer' : '✅ Créer le stagiaire' ?>
                </button>
            </div>

        </form>
    </div>
</div>