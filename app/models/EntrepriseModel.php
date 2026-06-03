<?php
/**
 * Modèle Entreprise
 * 
 * Gère les opérations CRUD sur la table entreprise.
 */

class EntrepriseModel extends Model
{
    private string $table = 'entreprise';

    /**
     * Récupère toutes les entreprises, triées par nom.
     */
    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table} ORDER BY nom");
        return $stmt->fetchAll();
    }

    /**
     * Récupère une entreprise par son numéro.
     */
    public function getById(int $id): array|false
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE numero_entreprise = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Crée une nouvelle entreprise.
     */
    public function create(array $data): int
    {
        $sql = "INSERT INTO {$this->table} (nom, secteur_activite, ville)
                VALUES (:nom, :secteur_activite, :ville)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':nom'              => $data['nom'],
            ':secteur_activite' => $data['secteur_activite'],
            ':ville'            => $data['ville'],
        ]);
        return (int) $this->db->lastInsertId();
    }

    /**
     * Met à jour une entreprise existante.
     */
    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE {$this->table}
                SET nom = :nom, secteur_activite = :secteur_activite, ville = :ville
                WHERE numero_entreprise = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nom'              => $data['nom'],
            ':secteur_activite' => $data['secteur_activite'],
            ':ville'            => $data['ville'],
            ':id'               => $id,
        ]);
    }

    /**
     * Supprime une entreprise.
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE numero_entreprise = ?");
        return $stmt->execute([$id]);
    }
}