<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        /* Styles pour le PDF mPDF */
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            color: #1e2d3d;
            margin: 0;
        }

        /* En-tête du document */
        .header {
            text-align: center;
            border-bottom: 3px solid #1a3a5c;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 18px;
            color: #1a3a5c;
            margin: 0 0 5px 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .header .subtitle {
            font-size: 12px;
            color: #6b7c93;
        }

        /* Sections d'informations */
        .info-grid {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .info-grid td {
            padding: 6px 10px;
            vertical-align: top;
            width: 50%;
        }

        .info-label {
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            color: #6b7c93;
            letter-spacing: .5px;
        }

        .info-value {
            font-size: 12px;
            font-weight: bold;
            color: #1a3a5c;
        }

        .info-sub {
            font-size: 10px;
            color: #6b7c93;
        }

        /* Tableau des critères */
        .criteres-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .criteres-table th {
            background: #1a3a5c;
            color: white;
            padding: 8px 10px;
            text-align: left;
            font-size: 10px;
        }

        .criteres-table td {
            padding: 7px 10px;
            border-bottom: 1px solid #d0dce8;
            font-size: 10px;
        }

        .criteres-table tr:nth-child(even) td {
            background: #f5f9ff;
        }

        /* Boîte note finale */
        .note-finale {
            background: #1a3a5c;
            color: white;
            text-align: center;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .note-finale .label {
            font-size: 10px;
            opacity: .8;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .note-finale .value {
            font-size: 32px;
            font-weight: 900;
            margin: 5px 0 3px;
        }

        .note-finale .sur {
            font-size: 11px;
            opacity: .7;
        }

        /* Zone de signature */
        .signature-zone {
            margin-top: 30px;
            width: 100%;
            border-collapse: collapse;
        }

        .signature-zone td {
            width: 33%;
            text-align: center;
            padding: 10px;
        }

        .sig-line {
            border-top: 1px solid #1a3a5c;
            margin-top: 30px;
            font-size: 9px;
            color: #6b7c93;
        }

        /* Pied de page */
        .footer {
            text-align: center;
            font-size: 9px;
            color: #6b7c93;
            margin-top: 20px;
            border-top: 1px solid #d0dce8;
            padding-top: 10px;
        }
    </style>
</head>
<body>

    <!-- ═══ EN-TÊTE DU PROCÈS-VERBAL ═══════════════════════════════════ -->
    <div class="header">
        <h1>Procès-verbal d'évaluation de stage</h1>
        <div class="subtitle">Document généré le <?= date('d/m/Y') ?></div>
    </div>

    <!-- ═══ INFORMATIONS GÉNÉRALES ═══════════════════════════════════════ -->
    <table class="info-grid">
        <tr>
            <td>
                <div class="info-label">Stagiaire</div>
                <div class="info-value">
                    <?php if (!empty($lignes)): ?>
                        <?= htmlspecialchars($lignes[0]['stagiaire_nom'] . ' ' . $lignes[0]['stagiaire_prenom']) ?>
                    <?php else: ?>
                        <?= htmlspecialchars(($stage['stagiaire_nom'] ?? '') . ' ' . ($stage['stagiaire_prenom'] ?? '')) ?>
                    <?php endif; ?>
                </div>
                <div class="info-sub">
                    <?= htmlspecialchars($lignes[0]['ecole'] ?? $stage['ecole'] ?? '') ?> —
                    <?= htmlspecialchars($lignes[0]['filiere'] ?? $stage['filiere'] ?? '') ?>
                </div>
            </td>
            <td>
                <div class="info-label">Entreprise d'accueil</div>
                <div class="info-value"><?= htmlspecialchars($lignes[0]['entreprise_nom'] ?? $stage['entreprise_nom'] ?? '') ?></div>
                <div class="info-sub"><?= htmlspecialchars($lignes[0]['ville'] ?? $stage['ville'] ?? '') ?></div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="info-label">Sujet du stage</div>
                <div class="info-value" style="font-size:11px;">
                    <?= htmlspecialchars($stage['sujet'] ?? '') ?>
                </div>
            </td>
            <td>
                <div class="info-label">Période de stage</div>
                <div class="info-value">
                    <?= date('d/m/Y', strtotime($stage['dateDebut'])) ?>
                    → <?= date('d/m/Y', strtotime($stage['dateFin'])) ?>
                </div>
            </td>
        </tr>
    </table>

    <!-- ═══ NOTE FINALE ══════════════════════════════════════════════════ -->
    <div class="note-finale">
        <div class="label">Note Finale Calculée</div>
        <div class="value"><?= $noteFinale !== null ? $noteFinale : '—' ?></div>
        <div class="sur">/ 20 &nbsp;|&nbsp; Formule : Σ(note × coeff) / Σ coefficients</div>
    </div>

    <!-- ═══ TABLEAU CRITÈRE / NOTE / COEFFICIENT ═════════════════════════ -->
    <table class="criteres-table">
        <thead>
            <tr>
                <th>Critère d'évaluation</th>
                <th>Coefficient</th>
                <th>Note / 20</th>
                <th>Note × Coefficient</th>
                <th>Observation</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lignes as $l): ?>
                <tr>
                    <td><?= htmlspecialchars($l['libelle_critere']) ?></td>
                    <td><?= $l['coefficient'] ?></td>
                    <td><strong><?= $l['note'] ?></strong></td>
                    <td><?= round($l['note'] * $l['coefficient'], 2) ?></td>
                    <td><?= htmlspecialchars($l['observation'] ?: '—') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- ═══ ZONES DE SIGNATURE ══════════════════════════════════════════ -->
    <table class="signature-zone">
        <tr>
            <td>
                <div class="sig-line">Responsable de stage<br>en entreprise</div>
            </td>
            <td>
                <div class="sig-line">Encadreur pédagogique<br>de l'école</div>
            </td>
            <td>
                <div class="sig-line">Le stagiaire</div>
            </td>
        </tr>
    </table>

    <!-- ═══ PIED DE PAGE ════════════════════════════════════════════════ -->
    <div class="footer">
        Document généré automatiquement par GestionStage — <?= date('d/m/Y H:i') ?>
    </div>

</body>
</html>