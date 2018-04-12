<?php

// On démarre les sessions
session_start();

// J'affiche les erreurs
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Je met un temps maximum d'execution faible
set_time_limit(5);

// Je déclare une constante qui contient
// le chemin du dossier de base de mon application
define('ABS_BASE_PATH', __DIR__);

// On inclue l'autoload de Composer pour inclure
// automatiquement toutes les classes du projet
require(__DIR__ . '/vendor/autoload.php');

// Initialisation de notre jeu
$launcher = new BattleShip\Launcher();
// On le démarre
$launcher->run();
