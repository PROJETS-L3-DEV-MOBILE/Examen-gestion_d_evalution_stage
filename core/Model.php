<?php
/**
 * Classe Model – classe mère abstraite pour tous les modèles.
 * Fournit les opérations CRUD génériques via PDO.
 */
abstract class Model
{
    protected PDO    $db;
    protected string $table;
    protected string $primaryKey;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    /** Retourne tous les enregistrements de la table. */
    public function findAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll();
    }

    /** Retourne un enregistrement par sa clé primaire. */
    public function findById(int $id): array|false
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?"
        );
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /** Supprime un enregistrement par sa clé primaire. */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare(
            "DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?"
        );
        return $stmt->execute([$id]);
    }

    /** Retourne le nombre total d'enregistrements. */
    public function count(): int
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM {$this->table}");
        return (int) $stmt->fetchColumn();
    }
}
