<?php
/**
 * Modèle Evaluation – gère la table Evaluation.
 */
class Evaluation extends Model
{
    protected string $table      = 'Evaluation';
    protected string $primaryKey = 'numero_evaluation';

    /** Retourne toutes les évaluations d'un stage avec les détails du critère. */
    public function findByStage(int $stageId): array
    {
        $stmt = $this->db->prepare(
            "SELECT ev.*, cr.libelle_critere, cr.coefficient
             FROM Evaluation ev
             JOIN CritereEvaluation cr ON ev.id_critere = cr.id_critere
             WHERE ev.numero_stage = :id
             ORDER BY cr.libelle_critere"
        );
        $stmt->execute([':id' => $stageId]);
        return $stmt->fetchAll();
    }

    /** Retourne l'évaluation d'un critère pour un stage donné, ou false si inexistante. */
    public function findByCritereAndStage(int $critereId, int $stageId): array|false
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM Evaluation
             WHERE id_critere = :critere AND numero_stage = :stage"
        );
        $stmt->execute([':critere' => $critereId, ':stage' => $stageId]);
        return $stmt->fetch();
    }

    /**
     * Crée ou met à jour l'évaluation d'un critère pour un stage.
     * Valide la note selon le barème du stage (0-bareme).
     * La note finale est automatiquement recalculée (calculée à la demande dans le modèle Stage).
     */
    public function saveOrUpdate(int $stageId, int $critereId, float $note, string $observation, float $bareme): bool
    {
        if ($note < 0 || $note > $bareme) {
            throw new InvalidArgumentException(
                "La note doit être comprise entre 0 et {$bareme}."
            );
        }

        $existing = $this->findByCritereAndStage($critereId, $stageId);

        if ($existing) {
            $stmt = $this->db->prepare(
                "UPDATE Evaluation SET note=:note, observation=:obs
                 WHERE numero_evaluation=:id"
            );
            return $stmt->execute([
                ':note' => $note,
                ':obs'  => $observation ?: null,
                ':id'   => $existing['numero_evaluation'],
            ]);
        }

        $stmt = $this->db->prepare(
            "INSERT INTO Evaluation (note, observation, id_critere, numero_stage)
             VALUES (:note, :obs, :critere, :stage)"
        );
        return $stmt->execute([
            ':note'    => $note,
            ':obs'     => $observation ?: null,
            ':critere' => $critereId,
            ':stage'   => $stageId,
        ]);
    }

    /** Supprime toutes les évaluations d'un stage. */
    public function deleteByStage(int $stageId): bool
    {
        $stmt = $this->db->prepare("DELETE FROM Evaluation WHERE numero_stage = :id");
        return $stmt->execute([':id' => $stageId]);
    }
}
