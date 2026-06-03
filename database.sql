-- =============================================================
-- Script de création de la base de données : gestion_stages
-- =============================================================

CREATE DATABASE IF NOT EXISTS gestion_stages
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE gestion_stages;

-- Table des stagiaires
CREATE TABLE IF NOT EXISTS Stagiaire (
    numero_stagiaire INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom              VARCHAR(100) NOT NULL,
    prenom           VARCHAR(100) NOT NULL,
    email            VARCHAR(150) UNIQUE,
    ecole            VARCHAR(200),
    filiere          VARCHAR(200)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table des entreprises
CREATE TABLE IF NOT EXISTS Entreprise (
    numero_entreprise INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom               VARCHAR(200) NOT NULL,
    secteur_activite  VARCHAR(200),
    ville             VARCHAR(100)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table des stages
-- bareme : 10 ou 20 (barème de notation utilisé pour ce stage)
-- statut : actif ou termine
CREATE TABLE IF NOT EXISTS Stage (
    numero_stage      INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    sujet             VARCHAR(300) NOT NULL,
    dateDebut         DATE         NOT NULL,
    dateFin           DATE         NOT NULL,
    bareme            TINYINT      NOT NULL DEFAULT 20,
    statut            ENUM('actif','termine') NOT NULL DEFAULT 'actif',
    numero_stagiaire  INT UNSIGNED NOT NULL,
    numero_entreprise INT UNSIGNED NOT NULL,
    CONSTRAINT chk_dates CHECK (dateDebut < dateFin),
    CONSTRAINT fk_stage_stagiaire  FOREIGN KEY (numero_stagiaire)  REFERENCES Stagiaire(numero_stagiaire)  ON DELETE RESTRICT,
    CONSTRAINT fk_stage_entreprise FOREIGN KEY (numero_entreprise) REFERENCES Entreprise(numero_entreprise) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table des critères d'évaluation
CREATE TABLE IF NOT EXISTS CritereEvaluation (
    id_critere      INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    libelle_critere VARCHAR(300)    NOT NULL,
    coefficient     DECIMAL(5,2)   NOT NULL DEFAULT 1.00,
    CONSTRAINT chk_coeff CHECK (coefficient >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table des évaluations
-- Une évaluation = une note pour un critère donné dans un stage donné
CREATE TABLE IF NOT EXISTS Evaluation (
    numero_evaluation INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    note              DECIMAL(5,2) NOT NULL,
    observation       TEXT,
    id_critere        INT UNSIGNED NOT NULL,
    numero_stage      INT UNSIGNED NOT NULL,
    CONSTRAINT uq_eval          UNIQUE KEY (id_critere, numero_stage),
    CONSTRAINT fk_eval_critere  FOREIGN KEY (id_critere)    REFERENCES CritereEvaluation(id_critere) ON DELETE RESTRICT,
    CONSTRAINT fk_eval_stage    FOREIGN KEY (numero_stage)  REFERENCES Stage(numero_stage)           ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================================
-- Données d'exemple
-- =============================================================

INSERT INTO Stagiaire (nom, prenom, email, ecole, filiere) VALUES
('Rakoto',    'Jean',   'jean.rakoto@gmail.com',    'ESMIA',   'Informatique'),
('Rabe',      'Marie',  'marie.rabe@gmail.com',     'EMIT',    'Génie Logiciel'),
('Andry',     'Paul',   'paul.andry@gmail.com',     'IT University', 'Systèmes');

INSERT INTO Entreprise (nom, secteur_activite, ville) VALUES
('Orange Madagascar', 'Télécommunications', 'Antananarivo'),
('BNI Madagascar',    'Finance',            'Antananarivo'),
('Jirama',            'Energie',            'Fianarantsoa');

INSERT INTO CritereEvaluation (libelle_critere, coefficient) VALUES
('Compétences techniques',   3.00),
('Qualité du travail',       2.00),
('Ponctualité et assuidité', 1.00),
('Communication',            1.50),
('Initiative et autonomie',  2.50);
