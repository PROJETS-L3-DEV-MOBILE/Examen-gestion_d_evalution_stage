# Gestion des Evaluations de Stage

Application web professionnelle de gestion des évaluations de stages étudiants.

**Architecture :** MVC en PHP pur avec POO et PDO  
**Base de données :** MySQL InnoDB  
**Design :** Bootstrap 5 + CSS moderne et technologique  
**PHP :** 8.0+

---

## Membres du groupe

| N° | Nom complet                              |
|----|------------------------------------------|
| 4  | MAHATRATRANIMARO Adolph                  |
| 6  | RAKOTONOELY Mahiratra Tadiavina          |
| 13 | RANDRIANASOLO Anja Toky Pascal           |

---

## Fonctionnalités principales

### Gestion des données (CRUD)
- Stagiaires (création, modification, suppression, visualisation)
- Entreprises (création, modification, suppression, visualisation)
- Critères d'évaluation (création, modification, suppression avec coefficients)
- Attribution et gestion des stages

### Évaluations et calculs
- Saisie des notes par critère et par stage
- Modification possible à tout moment
- Recalcul automatique de la note finale après chaque modification
- Formule : Note finale = (Σ note × coefficient) / Σ coefficients

### Rapports et classements
- Classement des stagiaires par note finale décroissante
- Fiche d'évaluation individuelle détaillée
- Impression/export PDF depuis le navigateur

---

## Règles de gestion implémentées

- Un stagiaire ne peut avoir qu'un seul stage actif à la fois
- La date de début doit être strictement antérieure à la date de fin
- Un coefficient ne peut pas être négatif
- Une note doit être comprise entre 0 et le barème du stage (10 ou 20)
- La note finale ne peut être calculée si tous les coefficients sont nuls
- Note finale = (Σ note × coefficient) / Σ coefficients

---

## Prérequis

- PHP >= 8.0 avec extensions PDO et PDO_MySQL
- MySQL >= 5.7 ou MariaDB >= 10.3
- Serveur Apache avec mod_rewrite activé
- XAMPP / LAMPP recommandé

---

## Installation et configuration

### 1. Placer le projet dans le dossier web

```bash
# Linux LAMPP
/opt/lampp/htdocs/gestion_stages/

# Windows XAMPP
C:\xampp\htdocs\gestion_stages\
```

### 2. Importer la base de données

**Option 1 : Avec phpMyAdmin**
- Aller sur http://localhost/phpmyadmin
- Importer le fichier `database.sql`

**Option 2 : Avec le terminal**
```bash
mysql -u root -p < database.sql
```

### 3. Configurer la connexion à la base de données

Éditer le fichier `config/database.php` :

```php
<?php
return [
    'host'     => '127.0.0.1',
    'dbname'   => 'gestion_stages',
    'username' => 'root',
    'password' => '',                 // Vide par défaut sous XAMPP/LAMPP
    'charset'  => 'utf8mb4',
];
```

### 4. Configurer l'URL de base (si nécessaire)

Vérifier/modifier `config/app.php` :

```php
define('BASE_URL', 'http://localhost/gestion_stages');
```

### 5. Définir les permissions (Linux/Mac)

```bash
chmod 755 /opt/lampp/htdocs/gestion_stages
chmod 644 config/database.php
```

### 6. Démarrer XAMPP/LAMPP

```bash
# Linux
sudo /opt/lampp/lampp start

# Windows
# Double-cliquer sur xampp_start.exe ou htdocs/xampp_control.exe
```

---

## Accès à l'application

### URL d'accès

```
http://localhost/gestion_stages
```

ou

```
http://localhost/gestion_stages/public/
```

---

## Données de démonstration

La base de données est préremplie avec des données d'exemple :

**Stagiaires :**
- RAKOTO Jean (ESMIA - Informatique)
- RABE Marie (EMIT - Génie Logiciel)
- ANDRY Paul (IT University - Systèmes)

**Entreprises :**
- Orange Madagascar (Télécommunications - Antananarivo)
- BNI Madagascar (Finance - Antananarivo)
- Jirama (Énergie - Fianarantsoa)

**Critères d'évaluation :**
- Compétences techniques (coefficient 3.0)
- Qualité du travail (coefficient 2.0)
- Ponctualité et assiduité (coefficient 1.0)
- Communication (coefficient 1.5)
- Initiative et autonomie (coefficient 2.5)

**Note :** Pas de système de login - l'application est en accès libre.

---

## Architecture du projet

```
gestion_stages/
├── app/
│   ├── controllers/
│   │   ├── HomeController.php
│   │   ├── StagiaireController.php
│   │   ├── EntrepriseController.php
│   │   ├── StageController.php
│   │   ├── CritereController.php
│   │   └── EvaluationController.php
│   ├── models/
│   │   ├── Stagiaire.php
│   │   ├── Entreprise.php
│   │   ├── Stage.php
│   │   ├── CritereEvaluation.php
│   │   └── Evaluation.php
│   └── views/
│       ├── layouts/
│       │   ├── header.php
│       │   ├── footer.php
│       │   └── main.php
│       ├── home/
│       ├── stagiaires/
│       ├── entreprises/
│       ├── stages/
│       ├── criteres/
│       └── evaluations/
├── config/
│   ├── app.php
│   └── database.php
├── core/
│   ├── autoload.php
│   ├── Database.php
│   ├── Model.php
│   ├── Controller.php
│   └── Router.php
├── public/
│   ├── index.php
│   ├── .htaccess
│   ├── css/
│   │   └── style.css
│   └── js/
│       └── app.js
├── database/
│   └── database.sql
├── .htaccess
├── index.php
└── README.md
```

---

## Navigation et routes

| Page | Route | Description |
|------|-------|-------------|
| Accueil | `index.php` | Tableau de bord avec statistiques |
| Stagiaires | `?controller=stagiaire&action=index` | Liste des stagiaires |
| Créer stagiaire | `?controller=stagiaire&action=create` | Formulaire de création |
| Modifier stagiaire | `?controller=stagiaire&action=edit&id=N` | Formulaire de modification |
| Détail stagiaire | `?controller=stagiaire&action=show&id=N` | Fiche détaillée + stages |
| Entreprises | `?controller=entreprise&action=index` | Liste des entreprises |
| Critères | `?controller=critere&action=index` | Liste des critères |
| Stages | `?controller=stage&action=index` | Liste des stages |
| Créer stage | `?controller=stage&action=create` | Attribution d'un stage |
| Saisie évaluations | `?controller=evaluation&action=saisie&stage=N` | Saisie des notes |
| Fiche évaluation | `?controller=evaluation&action=fiche&stage=N` | Fiche détaillée |
| Classement | `?controller=evaluation&action=classement` | Classement des stagiaires |
| Impression | `?controller=evaluation&action=imprimer&stage=N` | Export PDF |

---

## Utilisation - Workflow type

### 1. Préparation
- Vérifier les stagiaires et entreprises
- Configurer les critères d'évaluation et leurs coefficients

### 2. Attributio d'un stage
- Cliquer sur "Stages" > "Ajouter un stage"
- Sélectionner un stagiaire et une entreprise
- Définir le sujet et les dates
- Valider

### 3. Saisie des évaluations
- Cliquer sur "Stages" ou "Évaluations"
- Cliquer sur le bouton "Saisie des notes"
- Remplir les notes pour chaque critère
- Ajouter des observations si nécessaire
- Valider

### 4. Consultation des résultats
- Consulter la fiche d'évaluation complète
- Exporter/imprimer le PDF depuis le navigateur
- Consulter le classement final

---

## Dépannage

### Erreur "Vue introuvable"
- Vérifier que le dossier `app/views` existe avec toutes les sous-dossiers

### Erreur de connexion à la base de données
- Vérifier `config/database.php`
- S'assurer que MySQL/MariaDB est en cours d'exécution
- Vérifier l'utilisateur et le mot de passe MySQL
- Vérifier que l'extension PDO est activée

### CSS/JS ne chargent pas
- Vérifier que `BASE_URL` dans `config/app.php` est correct
- Vérifier les permissions des fichiers CSS et JS
- Vider le cache du navigateur (Ctrl+Shift+Del)

### .htaccess ne fonctionne pas
- Vérifier que mod_rewrite est activé
- Vérifier que AllowOverride All est configuré
- Redémarrer Apache

---

## Technologie et design patterns

**Backend :**
- PHP 8.0+ avec POO et interfaces
- PDO pour l'accès à la base de données
- Prepared statements pour la sécurité
- Design pattern MVC

**Frontend :**
- HTML5 sémantique
- CSS3 moderne avec gradients et animations
- Bootstrap 5 pour la responsivité
- JavaScript vanilla pour les interactions

**Base de données :**
- MySQL InnoDB avec contraintes
- Clés étrangères et CASCADE
- Transactions pour l'intégrité des données

---

## Fonctionnalités complètes du code

✓ Architecture MVC avec séparation des responsabilités  
✓ POO avec héritage (Model, Controller)  
✓ PDO avec prepared statements (prévention SQL injection)  
✓ Validation côté backend et frontend  
✓ Gestion des erreurs avec try/catch  
✓ Messages flash pour l'UX  
✓ Code indenté et commenté  
✓ Sans emojis  
✓ Design moderne et technologique  
✓ Opérationnel immédiatement après clonage  

---

## Améliorations possibles

- Authentification multi-utilisateurs avec rôles
- Pagination pour les longues listes
- Recherche et filtres avancés
- Export Excel/CSV
- Backup automatique
- Tests unitaires avec PHPUnit
- API REST
- Notifications par email

---

## Documentation du code

Le code est généreusement commenté avec :
- Documentation de bloc pour les classes et méthodes
- Commentaires de ligne pour la logique complexe
- Noms de variables explicites en français

---

## Support et contact

Pour toute question ou problème, consulter le code source avec les commentaires fournis.

**Auteurs :** MAHATRATRANIMARO Adolph, RAKOTONOELY Mahiratra Tadiavina, RANDRIANASOLO Anja Toky Pascal  
**Projet :** Examen - Gestion des Évaluations de Stage  
**Date :** 3 juin 2026
