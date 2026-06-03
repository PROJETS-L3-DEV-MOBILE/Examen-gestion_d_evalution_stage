<?php
/**
 * Classe Model — Base pour tous les modèles
 *
 * Fournit un accès commun à la base de données via PDO.
 */

abstract class Model
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getPdo();
    }
}
