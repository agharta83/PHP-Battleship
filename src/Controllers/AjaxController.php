<?php

namespace BattleShip\Controllers;

use BattleShip\Models\Board;

class AjaxController extends CoreController {

    public function generate() {
        // appelée lorsque le joueur clique sur "nouvelle partie"

        // créer un board pour le player
        $playerBoard = new Board;

        // poser des bateaux de façon aléatoire dessus
        $playerBoard->generate();


        // créer un board pour l'adversaire
        $opponentBoard = new Board;

        // poser des bateaux de façon aléatoire dessus
        // DONE dans le Model
        $opponentBoard->generate();

        // DONE stocker le résultat en session
        $_SESSION['player'] = [];
        $_SESSION['player']['board'] = serialize($playerBoard);
        $_SESSION['player']['shots'] = [];
        $_SESSION['opponent'] = [];
        $_SESSION['opponent']['board'] = serialize($opponentBoard);
        $_SESSION['opponent']['shots'] = [];

        // DONE  retourner le contenu de la board player au joueur
        $data = [
            "board" => $playerBoard->getBoard()
        ];

        $this->sendAjaxResponse($data);

    }

    public function fire() {
        // récupérer les coordonnées ou shoot mon player
        $shotCoords = $_POST['coordinates'];

        // echo $shotCoords;
        // die();

        // j'enregistre le shot
        $_SESSION['player']['shots'][] = $shotCoords;

        // vérifier s'il y a quelque chose dans la case du board de l'opposant
        $opponentBoard = unserialize($_SESSION['opponent']['board']);

        // if($opponentBoard->isEmpty($shotCoords)) {
        //     // si oui => résultat = "plouf"
        //     $touch = false;
        // }
        // else {
        //     // si non => résultat = touché!
        //     $touch = true;
        // }
        $touch = !$opponentBoard->isEmpty($shotCoords);

        // renvoyer le resultat en json
        // DONE  retourner le contenu de la board player au joueur
        $data = [
            "touch" => $touch
        ];

        $this->sendAjaxResponse($data);
    }

    public function dodge() {
        // la machine va choisir des coordonnées au hasard pour shoot
        do {
            $shotLat = rand(1, Board::WIDTH);
            $shotLong = rand(1, Board::HEIGHT);
            $shotCoords = $shotLat . '-' . $shotLong;
        }
        // tant qu'elle a déjà shooté, elle rechoisit
        while(in_array($shotCoords, $_SESSION['opponent']['shots']));

        // quand on arrive ici, l'adversaire a choisi des coordonnées qu'il n'a pas encore tapées

        // enregistrer le shot de l'opposant
        $_SESSION['opponent']['shots'][] = $shotCoords;

        // regarder sur le board du player le résultat du shoot
        $boardPlayer = unserialize($_SESSION['player']['board']);
        $touch = !$boardPlayer->isEmpty($shotCoords);

        // et l'envoyer au player.
        $data = [
            "shotCoords" => $shotCoords,
            "touch" => $touch
        ];

        $this->sendAjaxResponse($data);
    }
}
