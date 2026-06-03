# Gestion des Evaluations de Stage

Application web de gestion des evaluations de stages etudiants.
Architecture MVC en PHP pur avec PDO et MySQL.

---

## Membres du groupe

| N° | Nom complet                  |
|----|------------------------------|
| 1  | RAKOTO Jean                  |
| 2  | RABE Marie                   |

*(Remplacer par les vrais noms complets)*

---

## Fonctionnalites

- Gestion des stagiaires (CRUD)
- Gestion des entreprises (CRUD)
- Gestion des criteres d'evaluation (CRUD)
- Attribution d'un stage (stagiaire + entreprise + sujet + dates)
- Saisie et modification des evaluations par critere
- Recalcul automatique de la note finale apres chaque modification
- Classement des stagiaires par note finale decroissante
- Fiche d'evaluation individuelle (affichage + impression / export PDF navigateur)

---

## Regles de gestion implementees

- Un stagiaire ne peut avoir qu'un seul stage actif a la fois
- dateDebut doit etre strictement anterieure a dateFin (controle front et back)
- Un coefficient ne peut pas etre negatif
- Une note est validee entre 0 et le bareme du stage (10 ou 20)
- Impossible de calculer la note finale si la somme des coefficients est nulle
- Note finale = somme(note x coefficient) / somme(coefficients)

---

## Prerequis

- PHP >= 8.0
- MySQL >= 5.7 ou MariaDB >= 10.3
- Serveur Apache (XAMPP / LAMPP recommande)
- Extension PDO et PDO_MySQL activees

---

## Instructions d'installation

### 1. Placer le projet dans le dossier web

```
/opt/lampp/htdocs/examen/Examen-gestion_d_evalution_stage/   (Linux LAMPP)
C:\xampp\htdocs\examen\Examen-gestion_d_evalution_stage\      (Windows XAMPP)
```

### 2. Creer la base de donnees

Ouvrir phpMyAdmin (`http://localhost/phpmyadmin`) ou utiliser le terminal :

```bash
mysql -u root -p < database.sql
```

Ou copier-coller le contenu de `database.sql` dans l'onglet SQL de phpMyAdmin.

### 3. Configurer la connexion

Editer le fichier `config/database.php` :

```php
return [
    'host'     => 'localhost',   // Hote MySQL
    'dbname'   => 'gestion_stages',
    'username' => 'root',        // Utilisateur MySQL
    'password' => '',            // Mot de passe (vide par defaut sous XAMPP/LAMPP)
    'charset'  => 'utf8mb4',
];
```

### 4. Acceder a l'application

```
http://localhost/examen/Examen-gestion_d_evalution_stage/
```

---

## Acces par defaut

L'application n'implemente pas de systeme d'authentification (hors perimetre du projet).
Elle est directement accessible via le navigateur.

Donnees de demonstration inserees par `database.sql` :
- 3 stagiaires
- 3 entreprises
- 5 criteres d'evaluation pre-configures

---

## Structure du projet

```
Examen-gestion_d_evalution_stage/
├── index.php              Point d'entree unique (front controller)
├── database.sql           Schema SQL + donnees d'exemple
├── config/
│   └── database.php       Configuration de la base de donnees
├── core/
│   ├── Database.php       Singleton PDO
│   ├── Model.php          Classe mere des modeles
│   ├── Controller.php     Classe mere des controleurs
│   └── Router.php         Routeur (GET controller + action)
├── app/
│   ├── controllers/       StagiaireController, EntrepriseController, etc.
│   ├── models/            Stagiaire, Entreprise, Stage, CritereEvaluation, Evaluation
│   └── views/
│       ├── layouts/       header.php + footer.php (Bootstrap 5)
│       ├── home/          Tableau de bord
│       ├── stagiaires/    Liste, formulaire, detail
│       ├── entreprises/   Liste, formulaire
│       ├── criteres/      Liste, formulaire
│       ├── stages/        Liste, formulaire, detail
│       └── evaluations/   Saisie, fiche, classement, impression
└── public/
    ├── css/style.css
    └── js/app.js
```

---

## Navigation des routes

| URL                                          | Description                  |
|----------------------------------------------|------------------------------|
| `index.php`                                  | Tableau de bord              |
| `index.php?controller=stagiaire&action=index`| Liste des stagiaires         |
| `index.php?controller=entreprise&action=index`| Liste des entreprises       |
| `index.php?controller=critere&action=index`  | Liste des criteres           |
| `index.php?controller=stage&action=index`    | Liste des stages             |
| `index.php?controller=evaluation&action=saisie&stage=ID` | Saisie des notes |
| `index.php?controller=evaluation&action=fiche&stage=ID`  | Fiche individuelle |
| `index.php?controller=evaluation&action=classement`      | Classement        |
| `index.php?controller=evaluation&action=imprimer&stage=ID` | Impression PDF  |
