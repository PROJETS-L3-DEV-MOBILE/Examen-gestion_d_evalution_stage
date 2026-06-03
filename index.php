<?php
/**
 * Contrôleur frontal – point d'entrée unique de l'application.
 */

define('ROOT', __DIR__);
define('APP',  ROOT . '/app');
define('CORE', ROOT . '/core');

// Chargement du noyau
require_once CORE . '/Database.php';
require_once CORE . '/Model.php';
require_once CORE . '/Controller.php';
require_once CORE . '/Router.php';

// Démarrage du routeur
$router = new Router();
$router->dispatch();
