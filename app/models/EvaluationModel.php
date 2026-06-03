<?php
/**
 * Modèle Evaluation
 * 
 * Gère les évaluations : une note + observation par critère pour un stage.
 * 
 * Règles métier :
 *   - Note entre 0 et 20
 *   - Modification possible à tout moment
 *   - Note finale recalculée automatiquement après chaque modification
 *   - Formule : NoteFinale = (Σ note × coefficient) / Σ coefficients
 *   - On ne peut pas calculer si tous les coefficients sont nuls
 */

class EvaluationModel extends Model
{
    private string $table = 'evaluation';

    /**
     * Récupère toutes les évaluations d'un stage avec le libellé et coefficient du critère.
     */
    public function getByStage(int $idStage): array
    {
        $sql = "SELECT
                    ev.*,
                    ce.libelle_critere,
                    ce.coefficient
                FROM {$this->table} ev
                JOIN critere_evaluation ce ON ce.id_critere = ev.id_critere
                WHERE ev.numero_stage = ?
                ORDER BY ce.libelle_critere";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idStage]);
        return $stmt->fetchAll();
    }

    /**
     * Récupère une évaluation par son numéro.
     */
    public function getById(int $id): array|false
    {
        $sql = "SELECT ev.*, ce.libelle_critere, ce.coefficient
                FROM {$this->table} ev
                JOIN critere_evaluation ce ON ce.id_critere = ev.id_critere
                WHERE ev.numero_evaluation = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Crée une nouvelle évaluation (note + observation pour un critère d'un stage).
     * 
     * @throws InvalidArgumentException si la note est hors plage 0-20
     */
    public function create(array $data): int
    {
        // Validation de la note : doit être entre 0 et 20
        $note = (float)$data['note'];
        if ($note < 0 || $note > 20) {
            throw new InvalidArgumentException("La note doit être comprise entre 0 et 20.");
        }

        $sql = "INSERT INTO {$this->table} (note, observation, id_critere, numero_stage)
                VALUES (:note, :observation, :id_critere, :numero_stage)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':note'         => $note,
            ':observation'  => $data['observation'] ?? '',
            ':id_critere'   => $data['id_critere'],
            ':numero_stage' => $data['numero_stage'],
        ]);
        return (int) $this->db->lastInsertId();
    }

    /**
     * Met à jour une évaluation existante.
     * La note finale sera recalculée côté contrôleur après cet appel.
     */
    public function update(int $id, array $data): bool
    {
        $note = (float)$data['note'];
        if ($note < 0 || $note > 20) {
            throw new InvalidArgumentException("La note doit être comprise entre 0 et 20.");
        }

        $sql = "UPDATE {$this->table}
                SET note = :note, observation = :observation, id_critere = :id_critere
                WHERE numero_evaluation = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':note'        => $note,
            ':observation' => $data['observation'] ?? '',
            ':id_critere'  => $data['id_critere'],
            ':id'          => $id,
        ]);
    }

    /**
     * Supprime une évaluation.
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE numero_evaluation = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Calcule la note finale d'un stage.
     * 
     * Formule : NoteFinale = (Σ note × coefficient) / Σ coefficients
     * 
     * @return float|null  null si les coefficients sont tous nuls (division impossible)
     */
    public function calculerNoteFinale(int $idStage): ?float
    {
        $sql = "SELECT
                    SUM(ev.note * ce.coefficient) AS total_pondéré,
                    SUM(ce.coefficient)            AS total_coefficients
                FROM {$this->table} ev
                JOIN critere_evaluation ce ON ce.id_critere = ev.id_critere
                WHERE ev.numero_stage = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idStage]);
        $row = $stmt->fetch();

        // Règle : on ne peut pas calculer si la somme des coefficients est 0
        if (!$row || (float)$row['total_coefficients'] === 0.0) {
            return null;
        }

        return round((float)$row['total_pondéré'] / (float)$row['total_coefficients'], 2);
    }

    /**
     * Récupère la fiche complète d'évaluation d'un stage
     * (pour l'affichage détaillé et la génération PDF).
     */
    public function getFicheEvaluation(int $idStage): array
    {
        $sql = "SELECT
                    s.numero_stage,
                    s.sujet,
                    s.dateDebut,
                    s.dateFin,
                    st.nom AS stagiaire_nom,
                    st.prenom AS stagiaire_prenom,
                    st.ecole,
                    st.filiere,
                    e.nom AS entreprise_nom,
                    e.ville,
                    ce.libelle_critere,
                    ce.coefficient,
                    ev.note,
                    ev.observation
                FROM stage s
                JOIN stagiaire st ON st.numero_stagiaire = s.numero_stagiaire
                JOIN entreprise e ON e.numero_entreprise = s.numero_entreprise
                JOIN {$this->table} ev ON ev.numero_stage = s.numero_stage
                JOIN critere_evaluation ce ON ce.id_critere = ev.id_critere
                WHERE s.numero_stage = ?
                ORDER BY ce.libelle_critere";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idStage]);
        return $stmt->fetchAll();
    }
}