<?php
/**
 * Point d'entrée unique de l'application (Front Controller)
 * Toutes les requêtes sont routées vers ce fichier via .htaccess
 */

define('ROOT_PATH', dirname(__DIR__));
define('APP',  ROOT_PATH . '/app');
define('CORE', ROOT_PATH . '/core');

require_once CORE . '/Database.php';
require_once CORE . '/Model.php';
require_once CORE . '/Controller.php';
require_once CORE . '/Router.php';
require_once ROOT_PATH . '/config/app.php';
require_once ROOT_PATH . '/config/database.php';

$router = new Router();
$router->dispatch();
