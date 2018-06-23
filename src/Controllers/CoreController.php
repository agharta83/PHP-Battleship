<?php

namespace BattleShip\Controllers;

// une classe abstraite, désignée par le mot clé "abstract"
// indique une classe qui ne peut être instanciée
// on peut par contre HERITER de cette classe, et instancier la classe qui en hérite
// on indiquera souvent "abstract" devant une classe qui nous permet de définir un "comportement type", mais pas de traitement à proprement parler.
// ces traitement seront executés par les classes qui héritent de cette classe abstraite

abstract class CoreController {

    protected $router;
    protected $templates;

    public function __construct( $router ) {
        // On enregistre le routeur dans le controller
        $this->router = $router;

        // On instancie la librairie Plates pour gérer nos templates
        $this->templates = new \League\Plates\Engine( ABS_BASE_PATH . '/src/Views' );
        // On ajoute des données globales
        $this->templates->addData([
            'basePath' => $_SERVER['BASE_URI'] ?? '',
            'router' => $this->router,
        ]);
    }

    public function sendAjaxResponse($data) {

        // pour communiquer en AJAX, on encode les données qu'on veut envoyer au format json
        // et on prévient que les données envoyées
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    // Permet de faire une redirection
    public function redirect( $routeName, $infos = [] ) {
        header('Location: ' . $this->router->generate( $routeName, $infos ));
        exit();
    }
}
