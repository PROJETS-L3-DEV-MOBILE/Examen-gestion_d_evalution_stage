# Projet 5 — Gestion d'Évaluation de Stage (GE-IT)

## Membres du groupe
- [Nom Prénom 1] — N° étudiant
- [Nom Prénom 2] — N° étudiant
- [Nom Prénom 3] — N° étudiant

---

## Structure MVC

```
gestion-stage/
├── public/                  ← Dossier web (DocumentRoot)
│   ├── index.php            ← Point d'entrée unique
│   ├── .htaccess            ← Réécriture d'URL
│   └── css/
│       └── style.css
├── config/
│   ├── app.php              ← BASE_URL, APP_NAME, timezone
│   └── database.php         ← Identifiants BDD
├── core/                    ← Classes du framework maison
│   ├── autoload.php
│   ├── Database.php         ← Singleton PDO
│   ├── Router.php
│   ├── Controller.php       ← Classe abstraite
│   └── Model.php            ← Classe abstraite
├── app/
│   ├── controllers/
│   │   ├── HomeController.php
│   │   ├── StagiaireController.php
│   │   ├── EntrepriseController.php
│   │   ├── StageController.php
│   │   ├── CritereController.php
│   │   └── EvaluationController.php
│   ├── models/
│   │   ├── StagiaireModel.php
│   │   ├── EntrepriseModel.php
│   │   ├── StageModel.php
│   │   ├── CritereModel.php
│   │   └── EvaluationModel.php
│   └── views/
│       ├── layouts/main.php ← Layout commun (sidebar + topbar)
│       ├── home/
│       ├── stagiaires/
│       ├── entreprises/
│       ├── stages/
│       ├── criteres/
│       ├── evaluations/
│       └── pdf/             ← Template HTML pour mPDF
└── database/
    └── database.sql         ← Script de création + données de test
```

---

## Installation

### 1. Prérequis
- PHP >= 8.0
- MySQL ou MariaDB
- Apache avec `mod_rewrite` activé

### 2. Cloner le projet

```bash
git clone <URL_DU_REPO> gestion-stage
```

### 3. Configurer la base de données

```bash
mysql -u root -p < database/database.sql
```

### 4. Configurer l'application

Modifier `config/database.php` :
```php
define('DB_USER', 'root');    // votre utilisateur MySQL
define('DB_PASS', '');        // votre mot de passe MySQL
```

Modifier `config/app.php` si nécessaire :
```php
define('BASE_URL', 'http://localhost/gestion-stage/public');
```

### 5. Configurer Apache (Virtual Host ou XAMPP)

Pointer le `DocumentRoot` vers le dossier `public/`, ou
placer le projet dans `htdocs/` de XAMPP et accéder via :

```
http://localhost/gestion-stage/public/
```

### 6. Activer mod_rewrite (si nécessaire)

Dans `httpd.conf` ou `.htaccess` du vhost :
```
AllowOverride All
```

---

## Accès par défaut

Aucune authentification requise.
URL d'accueil : `http://localhost/gestion-stage/public/`

---

## Génération PDF

La génération PDF utilise **mPDF**. Pour l'activer :

```bash
composer require mpdf/mpdf
```

---

## Fonctionnalités

- ✅ CRUD Stagiaires
- ✅ CRUD Entreprises
- ✅ CRUD Critères d'évaluation
- ✅ Attribution de stage (avec contrôle dateDebut < dateFin)
- ✅ Évaluations par critère (note 0–20)
- ✅ Calcul automatique de la note finale pondérée
- ✅ Classement des stagiaires par note décroissante
- ✅ Fiche d'évaluation individuelle
- ✅ Génération PDF (avec mPDF)
