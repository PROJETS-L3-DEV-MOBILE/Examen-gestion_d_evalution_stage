<?php
/**
 * Modèle Entreprise – gère la table Entreprise.
 */
class Entreprise extends Model
{
    protected string $table      = 'Entreprise';
    protected string $primaryKey = 'numero_entreprise';

    /** Insère une nouvelle entreprise. */
    public function create(array $data): bool
    {
        $stmt = $this->db->prepare(
            "INSERT INTO Entreprise (nom, secteur_activite, ville)
             VALUES (:nom, :secteur, :ville)"
        );
        return $stmt->execute([
            ':nom'     => $data['nom'],
            ':secteur' => $data['secteur_activite'] ?: null,
            ':ville'   => $data['ville']            ?: null,
        ]);
    }

    /** Met à jour une entreprise existante. */
    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE Entreprise
             SET nom=:nom, secteur_activite=:secteur, ville=:ville
             WHERE numero_entreprise=:id"
        );
        return $stmt->execute([
            ':nom'     => $data['nom'],
            ':secteur' => $data['secteur_activite'] ?: null,
            ':ville'   => $data['ville']            ?: null,
            ':id'      => $id,
        ]);
    }
}
