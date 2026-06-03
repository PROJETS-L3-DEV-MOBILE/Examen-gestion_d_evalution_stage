<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>PV d'evaluation - <?= htmlspecialchars($stage['stagiaire_prenom'] . ' ' . $stage['stagiaire_nom']) ?></title>
    <style>
        /* Styles generaux */
        body {
            font-family: Arial, sans-serif;
            font-size: 12pt;
            color: #000;
            margin: 20mm 20mm 20mm 20mm;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 16pt;
            text-transform: uppercase;
            font-weight: bold;
            margin: 0 0 5px 0;
        }

        .header p {
            font-size: 10pt;
            color: #555;
            margin: 0;
        }

        .section {
            margin-bottom: 18px;
        }

        .section-title {
            font-size: 11pt;
            font-weight: bold;
            text-transform: uppercase;
            background: #f0f0f0;
            padding: 4px 8px;
            margin-bottom: 8px;
            border-left: 4px solid #333;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4px 20px;
        }

        .info-item {
            display: flex;
            gap: 8px;
        }

        .info-label {
            font-weight: bold;
            min-width: 90px;
            color: #444;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        table th {
            background: #333;
            color: #fff;
            padding: 6px 8px;
            text-align: left;
            font-size: 11pt;
        }

        table td {
            padding: 6px 8px;
            border-bottom: 1px solid #ccc;
        }

        table tr:nth-child(even) td {
            background: #f9f9f9;
        }

        table tfoot td {
            font-weight: bold;
            background: #eee;
            border-top: 2px solid #333;
        }

        .note-finale-box {
            border: 2px solid #000;
            display: inline-block;
            padding: 8px 24px;
            font-size: 18pt;
            font-weight: bold;
            margin-top: 8px;
        }

        .signature-zone {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
        }

        .signature-block {
            text-align: center;
            min-width: 200px;
        }

        .signature-block .ligne {
            border-top: 1px solid #000;
            margin-top: 50px;
            padding-top: 4px;
            font-size: 10pt;
        }

        /* Afficher uniquement en impression */
        .no-print { display: none; }

        /* Bouton impression - visible a l'ecran uniquement */
        @media screen {
            .no-print {
                display: block;
                position: fixed;
                top: 20px;
                right: 20px;
            }
        }

        @media print {
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

<!-- Bouton d'impression (visible uniquement a l'ecran) -->
<div class="no-print">
    <button onclick="window.print()" style="padding:10px 20px;font-size:14px;cursor:pointer;background:#007bff;color:#fff;border:none;border-radius:4px;">
        Imprimer / Sauvegarder en PDF
    </button>
    <button onclick="window.close()" style="margin-left:8px;padding:10px 20px;font-size:14px;cursor:pointer;background:#6c757d;color:#fff;border:none;border-radius:4px;">
        Fermer
    </button>
</div>

<!-- En-tete du document -->
<div class="header">
    <h1>Proces-Verbal d'Evaluation de Stage</h1>
    <p>Annee universitaire <?= date('Y') ?></p>
</div>

<!-- Informations du stagiaire -->
<div class="section">
    <div class="section-title">Stagiaire</div>
    <div class="info-grid">
        <div class="info-item">
            <span class="info-label">Nom :</span>
            <span><?= htmlspecialchars($stage['stagiaire_nom']) ?></span>
        </div>
        <div class="info-item">
            <span class="info-label">Prenom :</span>
            <span><?= htmlspecialchars($stage['stagiaire_prenom']) ?></span>
        </div>
        <div class="info-item">
            <span class="info-label">Ecole :</span>
            <span><?= htmlspecialchars($stage['ecole'] ?? '') ?></span>
        </div>
        <div class="info-item">
            <span class="info-label">Filiere :</span>
            <span><?= htmlspecialchars($stage['filiere'] ?? '') ?></span>
        </div>
    </div>
</div>

<!-- Informations de l'entreprise -->
<div class="section">
    <div class="section-title">Entreprise d'accueil</div>
    <div class="info-grid">
        <div class="info-item">
            <span class="info-label">Entreprise :</span>
            <span><?= htmlspecialchars($stage['entreprise_nom']) ?></span>
        </div>
        <div class="info-item">
            <span class="info-label">Secteur :</span>
            <span><?= htmlspecialchars($stage['secteur_activite'] ?? '') ?></span>
        </div>
        <div class="info-item">
            <span class="info-label">Ville :</span>
            <span><?= htmlspecialchars($stage['ville'] ?? '') ?></span>
        </div>
    </div>
</div>

<!-- Informations du stage -->
<div class="section">
    <div class="section-title">Stage</div>
    <div class="info-grid">
        <div class="info-item" style="grid-column: 1/-1">
            <span class="info-label">Sujet :</span>
            <span><?= htmlspecialchars($stage['sujet']) ?></span>
        </div>
        <div class="info-item">
            <span class="info-label">Debut :</span>
            <span><?= date('d/m/Y', strtotime($stage['dateDebut'])) ?></span>
        </div>
        <div class="info-item">
            <span class="info-label">Fin :</span>
            <span><?= date('d/m/Y', strtotime($stage['dateFin'])) ?></span>
        </div>
    </div>
</div>

<!-- Tableau d'evaluation -->
<div class="section">
    <div class="section-title">Grille d'evaluation (Bareme : /<?= $stage['bareme'] ?>)</div>

    <?php if (empty($evaluations)): ?>
        <p><em>Aucune evaluation enregistree.</em></p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Critere d'evaluation</th>
                    <th style="text-align:center;width:80px">Coefficient</th>
                    <th style="text-align:center;width:80px">Note</th>
                    <th>Observation</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($evaluations as $ev): ?>
                    <tr>
                        <td><?= htmlspecialchars($ev['libelle_critere']) ?></td>
                        <td style="text-align:center"><?= $ev['coefficient'] ?></td>
                        <td style="text-align:center;font-weight:bold"><?= $ev['note'] ?></td>
                        <td><?= htmlspecialchars($ev['observation'] ?? '') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" style="text-align:right">NOTE FINALE :</td>
                    <td style="text-align:center">
                        <?php if ($note_finale !== null): ?>
                            <span class="note-finale-box"><?= $note_finale ?>/<?= $stage['bareme'] ?></span>
                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                    <td></td>
                </tr>
            </tfoot>
        </table>

        <?php if ($note_finale !== null): ?>
            <p style="font-size:10pt;color:#555;margin-top:6px">
                Formule : Note finale = somme(note x coefficient) / somme(coefficients)
            </p>
        <?php endif; ?>
    <?php endif; ?>
</div>

<!-- Zone de signature -->
<div class="signature-zone">
    <div class="signature-block">
        <div class="ligne">Le Maitre de Stage</div>
    </div>
    <div class="signature-block">
        <div>Fait le : <?= date('d/m/Y') ?></div>
        <div class="ligne">Le Responsable Pedagogique</div>
    </div>
</div>

</body>
</html>
