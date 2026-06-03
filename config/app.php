<?php
/**
 * Configuration générale de l'application
 * Modifier BASE_URL selon votre environnement
 */

// URL de base — pointe vers le dossier /public
define('BASE_URL', 'http://localhost/gestion-stage/public');

// Chemin vers les vues
define('VIEWS_PATH', ROOT_PATH . '/app/views');

// Nom de l'application
define('APP_NAME', 'GestionStage');

// Fuseau horaire Madagascar
date_default_timezone_set('Indian/Antananarivo');
