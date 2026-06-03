<?php
/**
 * Modèle CritereEvaluation – gère la table CritereEvaluation.
 */
class CritereEvaluation extends Model
{
    protected string $table      = 'CritereEvaluation';
    protected string $primaryKey = 'id_critere';

    /** Insère un nouveau critère. Lance une exception si le coefficient est négatif. */
    public function create(array $data): bool
    {
        if ((float) $data['coefficient'] < 0) {
            throw new InvalidArgumentException("Le coefficient ne peut pas être négatif.");
        }

        $stmt = $this->db->prepare(
            "INSERT INTO CritereEvaluation (libelle_critere, coefficient)
             VALUES (:libelle, :coeff)"
        );
        return $stmt->execute([
            ':libelle' => $data['libelle_critere'],
            ':coeff'   => $data['coefficient'],
        ]);
    }

    /** Met à jour un critère existant. */
    public function update(int $id, array $data): bool
    {
        if ((float) $data['coefficient'] < 0) {
            throw new InvalidArgumentException("Le coefficient ne peut pas être négatif.");
        }

        $stmt = $this->db->prepare(
            "UPDATE CritereEvaluation
             SET libelle_critere=:libelle, coefficient=:coeff
             WHERE id_critere=:id"
        );
        return $stmt->execute([
            ':libelle' => $data['libelle_critere'],
            ':coeff'   => $data['coefficient'],
            ':id'      => $id,
        ]);
    }

    /** Retourne la somme de tous les coefficients. */
    public function sumCoefficients(): float
    {
        $stmt = $this->db->query("SELECT COALESCE(SUM(coefficient), 0) FROM CritereEvaluation");
        return (float) $stmt->fetchColumn();
    }
}
