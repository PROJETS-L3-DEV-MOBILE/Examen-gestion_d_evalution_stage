<?php
/**
 * Modèle Stage – gère la table Stage et les calculs de notes.
 */
class Stage extends Model
{
    protected string $table      = 'Stage';
    protected string $primaryKey = 'numero_stage';

    /**
     * Crée un nouveau stage.
     * Vérifie : dateDebut < dateFin et absence de stage actif pour le stagiaire.
     */
    public function create(array $data): bool
    {
        if (strtotime($data['dateDebut']) >= strtotime($data['dateFin'])) {
            throw new InvalidArgumentException("La date de début doit être antérieure à la date de fin.");
        }

        // Règle : un stagiaire ne peut avoir qu'un seul stage actif à la fois
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) FROM Stage
             WHERE numero_stagiaire = :sid AND statut = 'actif'"
        );
        $stmt->execute([':sid' => $data['numero_stagiaire']]);
        if ((int) $stmt->fetchColumn() > 0) {
            throw new RuntimeException("Ce stagiaire possède déjà un stage actif.");
        }

        $stmt = $this->db->prepare(
            "INSERT INTO Stage (sujet, dateDebut, dateFin, bareme, statut, numero_stagiaire, numero_entreprise)
             VALUES (:sujet, :debut, :fin, :bareme, 'actif', :stagiaire, :entreprise)"
        );
        return $stmt->execute([
            ':sujet'      => $data['sujet'],
            ':debut'      => $data['dateDebut'],
            ':fin'        => $data['dateFin'],
            ':bareme'     => in_array((int) $data['bareme'], [10, 20]) ? (int) $data['bareme'] : 20,
            ':stagiaire'  => $data['numero_stagiaire'],
            ':entreprise' => $data['numero_entreprise'],
        ]);
    }

    /** Met à jour un stage existant. */
    public function update(int $id, array $data): bool
    {
        if (strtotime($data['dateDebut']) >= strtotime($data['dateFin'])) {
            throw new InvalidArgumentException("La date de début doit être antérieure à la date de fin.");
        }

        $stmt = $this->db->prepare(
            "UPDATE Stage
             SET sujet=:sujet, dateDebut=:debut, dateFin=:fin, bareme=:bareme,
                 statut=:statut, numero_stagiaire=:stagiaire, numero_entreprise=:entreprise
             WHERE numero_stage=:id"
        );
        return $stmt->execute([
            ':sujet'      => $data['sujet'],
            ':debut'      => $data['dateDebut'],
            ':fin'        => $data['dateFin'],
            ':bareme'     => in_array((int) $data['bareme'], [10, 20]) ? (int) $data['bareme'] : 20,
            ':statut'     => in_array($data['statut'], ['actif','termine']) ? $data['statut'] : 'actif',
            ':stagiaire'  => $data['numero_stagiaire'],
            ':entreprise' => $data['numero_entreprise'],
            ':id'         => $id,
        ]);
    }

    /** Retourne tous les stages avec les informations du stagiaire et de l'entreprise. */
    public function findAllWithDetails(): array
    {
        $stmt = $this->db->query(
            "SELECT s.*,
                    st.nom AS stagiaire_nom, st.prenom AS stagiaire_prenom, st.ecole,
                    e.nom  AS entreprise_nom, e.ville
             FROM Stage s
             JOIN Stagiaire  st ON s.numero_stagiaire  = st.numero_stagiaire
             JOIN Entreprise e  ON s.numero_entreprise = e.numero_entreprise
             ORDER BY s.dateDebut DESC"
        );
        return $stmt->fetchAll();
    }

    /** Retourne un stage avec les détails complets du stagiaire et de l'entreprise. */
    public function findByIdWithDetails(int $id): array|false
    {
        $stmt = $this->db->prepare(
            "SELECT s.*,
                    st.nom AS stagiaire_nom, st.prenom AS stagiaire_prenom,
                    st.ecole, st.filiere, st.email AS stagiaire_email,
                    e.nom  AS entreprise_nom, e.secteur_activite, e.ville
             FROM Stage s
             JOIN Stagiaire  st ON s.numero_stagiaire  = st.numero_stagiaire
             JOIN Entreprise e  ON s.numero_entreprise = e.numero_entreprise
             WHERE s.numero_stage = :id"
        );
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Calcule la note finale d'un stage.
     * Formule : somme(note * coefficient) / somme(coefficients)
     * Retourne null si aucune évaluation ou si la somme des coefficients est nulle.
     */
    public function getNoteFinale(int $stageId): ?float
    {
        $stmt = $this->db->prepare(
            "SELECT SUM(ev.note * cr.coefficient) AS numerateur,
                    SUM(cr.coefficient)            AS denominateur
             FROM Evaluation ev
             JOIN CritereEvaluation cr ON ev.id_critere = cr.id_critere
             WHERE ev.numero_stage = :id"
        );
        $stmt->execute([':id' => $stageId]);
        $row = $stmt->fetch();

        if (!$row || $row['denominateur'] === null || (float) $row['denominateur'] == 0) {
            return null;
        }

        return round((float) $row['numerateur'] / (float) $row['denominateur'], 2);
    }

    /**
     * Retourne le classement des stagiaires par note finale décroissante.
     * N'inclut que les stages ayant au moins une évaluation.
     */
    public function getClassement(): array
    {
        $stmt = $this->db->query(
            "SELECT s.numero_stage, s.sujet, s.bareme, s.statut,
                    st.numero_stagiaire, st.nom, st.prenom, st.ecole, st.filiere,
                    e.nom AS entreprise_nom, e.ville,
                    SUM(ev.note * cr.coefficient) / NULLIF(SUM(cr.coefficient), 0) AS note_finale
             FROM Stage s
             JOIN Stagiaire           st ON s.numero_stagiaire  = st.numero_stagiaire
             JOIN Entreprise           e ON s.numero_entreprise = e.numero_entreprise
             JOIN Evaluation          ev ON ev.numero_stage = s.numero_stage
             JOIN CritereEvaluation   cr ON ev.id_critere  = cr.id_critere
             GROUP BY s.numero_stage, st.numero_stagiaire, e.numero_entreprise
             ORDER BY note_finale DESC"
        );
        return $stmt->fetchAll();
    }
}
