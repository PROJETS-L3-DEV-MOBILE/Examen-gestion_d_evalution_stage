<?php
/**
 * Point d'entrée unique de l'application (Front Controller)
 * Toutes les requêtes passent par ce fichier via .htaccess
 */

// Définir le chemin racine absolu du projet (dossier parent de /public)
define('ROOT_PATH', dirname(__DIR__));

// Charger les configurations
require_once ROOT_PATH . '/config/app.php';
require_once ROOT_PATH . '/config/database.php';

// Charger l'autoloader (charge automatiquement les classes)
require_once ROOT_PATH . '/core/autoload.php';

// Démarrer le routeur
Router::dispatch();
