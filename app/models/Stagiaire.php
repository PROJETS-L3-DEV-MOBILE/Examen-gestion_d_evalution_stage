<?php
/**
 * Modèle Stagiaire – gère la table Stagiaire.
 */
class Stagiaire extends Model
{
    protected string $table      = 'Stagiaire';
    protected string $primaryKey = 'numero_stagiaire';

    /** Insère un nouveau stagiaire. */
    public function create(array $data): bool
    {
        $stmt = $this->db->prepare(
            "INSERT INTO Stagiaire (nom, prenom, email, ecole, filiere)
             VALUES (:nom, :prenom, :email, :ecole, :filiere)"
        );
        return $stmt->execute([
            ':nom'     => $data['nom'],
            ':prenom'  => $data['prenom'],
            ':email'   => $data['email']   ?: null,
            ':ecole'   => $data['ecole']   ?: null,
            ':filiere' => $data['filiere'] ?: null,
        ]);
    }

    /** Met à jour un stagiaire existant. */
    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE Stagiaire
             SET nom=:nom, prenom=:prenom, email=:email, ecole=:ecole, filiere=:filiere
             WHERE numero_stagiaire=:id"
        );
        return $stmt->execute([
            ':nom'     => $data['nom'],
            ':prenom'  => $data['prenom'],
            ':email'   => $data['email']   ?: null,
            ':ecole'   => $data['ecole']   ?: null,
            ':filiere' => $data['filiere'] ?: null,
            ':id'      => $id,
        ]);
    }

    /** Vérifie si un email est déjà utilisé par un autre stagiaire. */
    public function emailExists(string $email, int $excludeId = 0): bool
    {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) FROM Stagiaire
             WHERE email = :email AND numero_stagiaire != :id"
        );
        $stmt->execute([':email' => $email, ':id' => $excludeId]);
        return (int) $stmt->fetchColumn() > 0;
    }

    /** Vérifie si le stagiaire possède déjà un stage actif. */
    public function hasActiveStage(int $id): bool
    {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) FROM Stage
             WHERE numero_stagiaire = :id AND statut = 'actif'"
        );
        $stmt->execute([':id' => $id]);
        return (int) $stmt->fetchColumn() > 0;
    }

    /** Retourne les stages d'un stagiaire avec les détails de l'entreprise. */
    public function getStages(int $id): array
    {
        $stmt = $this->db->prepare(
            "SELECT s.*, e.nom AS entreprise_nom, e.ville
             FROM Stage s
             JOIN Entreprise e ON s.numero_entreprise = e.numero_entreprise
             WHERE s.numero_stagiaire = :id
             ORDER BY s.dateDebut DESC"
        );
        $stmt->execute([':id' => $id]);
        return $stmt->fetchAll();
    }
}
