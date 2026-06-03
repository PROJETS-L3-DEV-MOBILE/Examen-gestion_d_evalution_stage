<?php
/**
 * Modèle Stagiaire
 * 
 * Gère toutes les opérations en base de données
 * relatives aux stagiaires (CRUD).
 */

class StagiaireModel extends Model
{
    // Nom de la table en base de données
    private string $table = 'stagiaire';

    /**
     * Récupère tous les stagiaires.
     */
    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table} ORDER BY nom, prenom");
        return $stmt->fetchAll();
    }

    /**
     * Récupère un stagiaire par son numéro.
     */
    public function getById(int $id): array|false
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE numero_stagiaire = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Crée un nouveau stagiaire.
     * Retourne l'ID inséré.
     */
    public function create(array $data): int
    {
        $sql = "INSERT INTO {$this->table} (nom, prenom, email, ecole, filiere)
                VALUES (:nom, :prenom, :email, :ecole, :filiere)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':nom'     => $data['nom'],
            ':prenom'  => $data['prenom'],
            ':email'   => $data['email'],
            ':ecole'   => $data['ecole'],
            ':filiere' => $data['filiere'],
        ]);
        return (int) $this->db->lastInsertId();
    }

    /**
     * Met à jour un stagiaire existant.
     */
    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE {$this->table}
                SET nom = :nom, prenom = :prenom, email = :email,
                    ecole = :ecole, filiere = :filiere
                WHERE numero_stagiaire = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nom'     => $data['nom'],
            ':prenom'  => $data['prenom'],
            ':email'   => $data['email'],
            ':ecole'   => $data['ecole'],
            ':filiere' => $data['filiere'],
            ':id'      => $id,
        ]);
    }

    /**
     * Supprime un stagiaire (uniquement si aucun stage actif).
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE numero_stagiaire = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Vérifie si un stagiaire a déjà un stage actif (dateDebut <= aujourd'hui <= dateFin).
     * Un stagiaire ne peut avoir qu'un seul stage actif à la fois.
     */
    public function hasActiveStage(int $idStagiaire): bool
    {
        $sql = "SELECT COUNT(*) FROM stage
                WHERE numero_stagiaire = ?
                AND dateDebut <= CURDATE()
                AND dateFin >= CURDATE()";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idStagiaire]);
        return (int) $stmt->fetchColumn() > 0;
    }

    /**
     * Récupère le classement des stagiaires par note finale décroissante.
     * Utilise la formule : NoteFinale = (Σ note × coefficient) / Σ coefficients
     */
    public function getClassement(): array
    {
        $sql = "SELECT
                    s.numero_stagiaire,
                    s.nom,
                    s.prenom,
                    s.ecole,
                    s.filiere,
                    st.sujet,
                    e.nom AS entreprise,
                    -- Calcul de la note finale pondérée
                    ROUND(
                        SUM(ev.note * ce.coefficient) / NULLIF(SUM(ce.coefficient), 0),
                        2
                    ) AS note_finale
                FROM {$this->table} s
                JOIN stage st ON st.numero_stagiaire = s.numero_stagiaire
                JOIN entreprise e ON e.numero_entreprise = st.numero_entreprise
                JOIN evaluation ev ON ev.numero_stage = st.numero_stage
                JOIN critere_evaluation ce ON ce.id_critere = ev.id_critere
                GROUP BY s.numero_stagiaire, st.numero_stage
                ORDER BY note_finale DESC";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
}