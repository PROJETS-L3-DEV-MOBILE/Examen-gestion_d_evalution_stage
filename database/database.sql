-- =====================================================
-- Base de données : gestion_stage
-- Projet 5 : Gestion d'Évaluation de Stage (GE-IT)
-- =====================================================

-- Création et sélection de la base de données
CREATE DATABASE IF NOT EXISTS gestion_stage
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE gestion_stage;

-- ─────────────────────────────────────────────────────
-- TABLE : stagiaire
-- Contient les informations des stagiaires
-- ─────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS stagiaire (
    numero_stagiaire INT AUTO_INCREMENT PRIMARY KEY,
    nom              VARCHAR(100) NOT NULL,
    prenom           VARCHAR(100) NOT NULL,
    email            VARCHAR(150) NOT NULL UNIQUE,
    ecole            VARCHAR(150) NOT NULL,
    filiere          VARCHAR(100) NOT NULL,
    created_at       TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ─────────────────────────────────────────────────────
-- TABLE : entreprise
-- Contient les informations des entreprises d'accueil
-- ─────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS entreprise (
    numero_entreprise INT AUTO_INCREMENT PRIMARY KEY,
    nom               VARCHAR(150) NOT NULL,
    secteur_activite  VARCHAR(100) NOT NULL,
    ville             VARCHAR(100) NOT NULL,
    created_at        TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ─────────────────────────────────────────────────────
-- TABLE : critere_evaluation
-- Critères avec leur libellé et coefficient de pondération
-- ─────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS critere_evaluation (
    id_critere      INT AUTO_INCREMENT PRIMARY KEY,
    libelle_critere VARCHAR(150) NOT NULL,
    coefficient     DECIMAL(5,2) NOT NULL DEFAULT 1.00,
    -- Contrainte : coefficient >= 0
    CONSTRAINT chk_coefficient CHECK (coefficient >= 0)
) ENGINE=InnoDB;

-- ─────────────────────────────────────────────────────
-- TABLE : stage
-- Attribution d'un stage à un stagiaire dans une entreprise
-- Clés étrangères vers stagiaire et entreprise
-- ─────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS stage (
    numero_stage      INT AUTO_INCREMENT PRIMARY KEY,
    sujet             VARCHAR(255)  NOT NULL,
    dateDebut         DATE          NOT NULL,
    dateFin           DATE          NOT NULL,
    numero_stagiaire  INT           NOT NULL,
    numero_entreprise INT           NOT NULL,
    created_at        TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    -- Règle : dateDebut < dateFin (vérifiée aussi côté PHP)
    CONSTRAINT chk_dates CHECK (dateDebut < dateFin),

    -- Lien vers la table stagiaire
    FOREIGN KEY (numero_stagiaire)
        REFERENCES stagiaire(numero_stagiaire)
        ON DELETE CASCADE ON UPDATE CASCADE,

    -- Lien vers la table entreprise
    FOREIGN KEY (numero_entreprise)
        REFERENCES entreprise(numero_entreprise)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ─────────────────────────────────────────────────────
-- TABLE : evaluation
-- Une note + observation par critère pour un stage
-- ─────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS evaluation (
    numero_evaluation INT AUTO_INCREMENT PRIMARY KEY,
    note              DECIMAL(5,2)  NOT NULL,
    observation       TEXT,
    id_critere        INT           NOT NULL,
    numero_stage      INT           NOT NULL,
    updated_at        TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    -- Règle : note entre 0 et 20
    CONSTRAINT chk_note CHECK (note >= 0 AND note <= 20),

    -- Lien vers la table critere_evaluation
    FOREIGN KEY (id_critere)
        REFERENCES critere_evaluation(id_critere)
        ON DELETE CASCADE ON UPDATE CASCADE,

    -- Lien vers la table stage
    FOREIGN KEY (numero_stage)
        REFERENCES stage(numero_stage)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- =====================================================
-- DONNÉES DE TEST (exemples pour démarrer rapidement)
-- =====================================================

-- Entreprises
INSERT INTO entreprise (nom, secteur_activite, ville) VALUES
    ('Tech Solutions SARL',     'Informatique',   'Antananarivo'),
    ('BNI Madagascar',          'Finance',         'Antananarivo'),
    ('Orange Madagascar',       'Télécommunications', 'Antananarivo'),
    ('Agence Web Créative',     'Communication',   'Fianarantsoa');

-- Stagiaires
INSERT INTO stagiaire (nom, prenom, email, ecole, filiere) VALUES
    ('Rakoto',    'Jean',    'jean.rakoto@email.mg',    'ENI Antananarivo',     'Génie Informatique'),
    ('Rasoamamy', 'Harifera','harifera.r@email.mg',     'EMIT Fianarantsoa',    'Réseaux & Télécoms'),
    ('Andrianasy','Fanja',   'fanja.and@email.mg',      'INSCAE Antananarivo',  'Finance & Comptabilité'),
    ('Razafy',    'Manda',   'manda.razafy@email.mg',   'ENI Antananarivo',     'Génie Logiciel');

-- Critères d'évaluation
INSERT INTO critere_evaluation (libelle_critere, coefficient) VALUES
    ('Qualité du travail réalisé',  3),
    ('Respect des délais',          2),
    ('Initiative et autonomie',     2),
    ('Comportement professionnel',  1.5),
    ('Communication et rapport',    1.5);

-- Stages
INSERT INTO stage (sujet, dateDebut, dateFin, numero_stagiaire, numero_entreprise) VALUES
    ('Développement d\'une application web de gestion RH', '2025-01-06', '2025-04-04', 1, 1),
    ('Analyse et optimisation du réseau LAN/WAN',          '2025-02-03', '2025-05-02', 2, 3),
    ('Audit financier et contrôle de gestion',             '2025-01-13', '2025-03-28', 3, 2);

-- Évaluations du stage 1 (Rakoto Jean)
INSERT INTO evaluation (note, observation, id_critere, numero_stage) VALUES
    (16, 'Excellent travail, code bien structuré',        1, 1),
    (14, 'Quelques retards mineurs en début de stage',    2, 1),
    (17, 'Très grande autonomie, force de proposition',   3, 1),
    (15, 'Très bon comportement professionnel',           4, 1),
    (16, 'Rapport bien rédigé, présentation claire',      5, 1);

-- Évaluations du stage 2 (Rasoamamy Harifera)
INSERT INTO evaluation (note, observation, id_critere, numero_stage) VALUES
    (13, 'Bon travail technique',                         1, 2),
    (15, 'Très ponctuel et respectueux des délais',       2, 2),
    (12, 'Progresse bien mais doit gagner en autonomie',  3, 2),
    (14, 'Sérieux et professionnel',                      4, 2),
    (13, 'Communication à améliorer',                     5, 2);