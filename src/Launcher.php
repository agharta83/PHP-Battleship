<?php

namespace BattleShip;

class Launcher
{

  public $router;

  public function __construct()
  {

    // Création du routeur
    $this->router = new \AltoRouter();

    // On ignore une partie de l'URL
    // On récupère donc la partie de l'URL qui
    // est fixe grâce à $_SERVER['BASE_URI']
    $basePath = isset($_SERVER['BASE_URI']) ? $_SERVER['BASE_URI'] : '';

    // On renseigne la partie de l'URL fixe
    $this->router->setBasePath($basePath);

    // On lance le mapping
    $this->mapping();
  }

  private function mapping()
  {
    // On mappe toutes nos URL
    // La page d'accueil
    $this->router->map('GET', '/', ['MainController', 'home'], 'home');

    // L'ajax qui génère les vaiseaux sur la carte
    $this->router->map('GET', '/ajax/generate', ['AjaxController', 'generate'], 'generate');
    // L'ajax pour faire feu !
    $this->router->map('POST', '/ajax/fire', ['AjaxController', 'fire'], 'fire');
    // L'ajax pour esquiver l'attaque de l'adversaire... ou pas !
    $this->router->map('GET', '/ajax/dodge', ['AjaxController', 'dodge'], 'dodge');
    // L'ajax pour tricher... PAS BIEN !
    $this->router->map('GET', '/ajax/opponent', ['AjaxController', 'opponent'], 'opponent');
  }

  public function run () {

      // Je récupère les données de Altorouter
      $match = $this->router->match();

      if (!$match) {

          // On a pas trouvé la route, on indique le nouveau chemin
          // $controller = new \BattleShip\Controllers\MainController();
          // $controller->error404();
          $controllerName = "\BattleShip\Controllers\MainController";
          $methodName = 'error404';
      }
      else {

          // Je regarde quel controller et quelle
          // méthode je dois exécuter
          // On pense à ajouter le namespace devant
          // le nom de la classe et à échapper le
          // dernier "\" pour ne pas perturber notre code
          $controllerName = "\BattleShip\Controllers\\" . $match['target'][0];
          $methodName = $match['target'][1];
      }

      // J'exécute la bonne et méthode
      // $controller = new BattleShip\Controllers\MainController();
      $controller = new $controllerName( $this->router );
      // On en profite pour transmettre les paramètres
      // contenus dans notre URL (si il y en a)
      $controller->$methodName( $match['params'] );
  }
}
