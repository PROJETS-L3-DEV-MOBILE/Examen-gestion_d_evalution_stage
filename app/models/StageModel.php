<?php
/**
 * Modèle Stage
 * 
 * Gère les opérations sur les stages.
 * Règles métier :
 *   - dateDebut < dateFin (obligatoire)
 *   - Un stagiaire ne peut avoir qu'un seul stage actif à la fois
 */

class StageModel extends Model
{
    protected string $table = 'stage';

    /**
     * Récupère tous les stages avec infos du stagiaire et de l'entreprise (JOIN).
     */
    public function getAll(): array
    {
        $sql = "SELECT
                    st.*,
                    s.nom AS stagiaire_nom,
                    s.prenom AS stagiaire_prenom,
                    e.nom AS entreprise_nom
                FROM {$this->table} st
                JOIN stagiaire s ON s.numero_stagiaire = st.numero_stagiaire
                JOIN entreprise e ON e.numero_entreprise = st.numero_entreprise
                ORDER BY st.dateDebut DESC";
        return $this->db->query($sql)->fetchAll();
    }

    /**
     * Récupère un stage par son numéro (avec détails stagiaire + entreprise).
     */
    public function getById(int $id): array|false
    {
        $sql = "SELECT
                    st.*,
                    s.nom AS stagiaire_nom,
                    s.prenom AS stagiaire_prenom,
                    s.ecole, s.filiere,
                    e.nom AS entreprise_nom,
                    e.ville, e.secteur_activite
                FROM {$this->table} st
                JOIN stagiaire s ON s.numero_stagiaire = st.numero_stagiaire
                JOIN entreprise e ON e.numero_entreprise = st.numero_entreprise
                WHERE st.numero_stage = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Crée un nouveau stage après validation des règles métier.
     * 
     * @throws InvalidArgumentException si les règles sont violées
     */
    public function create(array $data): int
    {
        // Règle : dateDebut doit être strictement avant dateFin
        if ($data['dateDebut'] >= $data['dateFin']) {
            throw new InvalidArgumentException("La date de début doit être antérieure à la date de fin.");
        }

        $sql = "INSERT INTO {$this->table} (sujet, dateDebut, dateFin, numero_stagiaire, numero_entreprise)
                VALUES (:sujet, :dateDebut, :dateFin, :numero_stagiaire, :numero_entreprise)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':sujet'             => $data['sujet'],
            ':dateDebut'         => $data['dateDebut'],
            ':dateFin'           => $data['dateFin'],
            ':numero_stagiaire'  => $data['numero_stagiaire'],
            ':numero_entreprise' => $data['numero_entreprise'],
        ]);
        return (int) $this->db->lastInsertId();
    }

    /**
     * Met à jour un stage existant.
     */
    public function update(int $id, array $data): bool
    {
        // Règle : dateDebut doit être strictement avant dateFin
        if ($data['dateDebut'] >= $data['dateFin']) {
            throw new InvalidArgumentException("La date de début doit être antérieure à la date de fin.");
        }

        $sql = "UPDATE {$this->table}
                SET sujet = :sujet, dateDebut = :dateDebut, dateFin = :dateFin,
                    numero_stagiaire = :numero_stagiaire, numero_entreprise = :numero_entreprise
                WHERE numero_stage = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':sujet'             => $data['sujet'],
            ':dateDebut'         => $data['dateDebut'],
            ':dateFin'           => $data['dateFin'],
            ':numero_stagiaire'  => $data['numero_stagiaire'],
            ':numero_entreprise' => $data['numero_entreprise'],
            ':id'                => $id,
        ]);
    }

    /**
     * Supprime un stage.
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE numero_stage = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Vérifie si un stagiaire a déjà un stage qui chevauche les dates données.
     * Exclut un stage spécifique (utile pour la mise à jour).
     */
    public function hasConflict(int $idStagiaire, string $debut, string $fin, ?int $excludeId = null): bool
    {
        // Détection de chevauchement de périodes
        $sql = "SELECT COUNT(*) FROM {$this->table}
                WHERE numero_stagiaire = ?
                AND dateDebut < ? AND dateFin > ?
                " . ($excludeId ? "AND numero_stage != ?" : "");

        $params = [$idStagiaire, $fin, $debut];
        if ($excludeId) $params[] = $excludeId;

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return (int) $stmt->fetchColumn() > 0;
    }
}