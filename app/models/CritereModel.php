<?php
/**
 * Modèle CritereEvaluation
 * 
 * Gère les critères d'évaluation (libellé + coefficient).
 * Règle : le coefficient ne peut pas être négatif.
 */

class CritereModel extends Model
{
    protected string $table = 'critere_evaluation';

    /**
     * Récupère tous les critères d'évaluation.
     */
    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table} ORDER BY libelle_critere");
        return $stmt->fetchAll();
    }

    /**
     * Récupère un critère par son ID.
     */
    public function getById(int $id): array|false
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id_critere = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Crée un nouveau critère d'évaluation.
     * 
     * @throws InvalidArgumentException si le coefficient est négatif
     */
    public function create(array $data): int
    {
        // Règle métier : coefficient ne peut pas être négatif
        if ((float)$data['coefficient'] < 0) {
            throw new InvalidArgumentException("Le coefficient ne peut pas être négatif.");
        }

        $sql = "INSERT INTO {$this->table} (libelle_critere, coefficient)
                VALUES (:libelle_critere, :coefficient)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':libelle_critere' => $data['libelle_critere'],
            ':coefficient'     => $data['coefficient'],
        ]);
        return (int) $this->db->lastInsertId();
    }

    /**
     * Met à jour un critère existant.
     */
    public function update(int $id, array $data): bool
    {
        if ((float)$data['coefficient'] < 0) {
            throw new InvalidArgumentException("Le coefficient ne peut pas être négatif.");
        }

        $sql = "UPDATE {$this->table}
                SET libelle_critere = :libelle_critere, coefficient = :coefficient
                WHERE id_critere = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':libelle_critere' => $data['libelle_critere'],
            ':coefficient'     => $data['coefficient'],
            ':id'              => $id,
        ]);
    }

    /**
     * Supprime un critère.
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id_critere = ?");
        return $stmt->execute([$id]);
    }
}