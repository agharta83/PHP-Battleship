<?php

namespace BattleShip\Models;

// On crée la classe Board pour représenter un tableau de jeu.
// On va avoir des infos communes à toutes les boards
// Et des infos particulières à chaque Board


class Board {

    // TOUTES LES BOARDS ONT LES MEMES DIMENSIONS
    // L'information "dimensions d'un board" est donc commune à toute la classe
    // et en plus ça ne change pas pendant l'éxécution du jeu (c'est un règle du jeu)
    const WIDTH = 10;
    const HEIGHT = 10;

    // liste des types de bateaux à placer sur le board :
    private static $shipList = ['Carrier', 'Battleship', 'Cruiser', 'Submarine', 'Destroyer'];

    // chaque Board aura un tableau qui représente son contenu.
    // contrairement à la taille qui ne change pas selon les boards, le contenu est particulier à CHAQUE Board. C'est donc une propriété d'objet.
    private $board = [];

    // la liste de bateaux du board
    private $boats = [];

    public function __construct() {
        // chaque tableau va avoir 100 cases (avec un contenu dans chacune : rien, ou un bateau)
        // dans l'ideal, chaque case a comme index ses coordonnées (comme ça on peut consulter facilement le contenu de la case B2 ==> 2-2)
        // pour chaque x allant de 1 à WIDTH
        for($x=1; $x<=self::WIDTH; $x++ ) {
            // pour chaque y allant de 1 à HEIGHT
            for ($y=1; $y <= self::HEIGHT ; $y++) {
                $this->board["$x-$y"] = '';
                // $this->board[$x . '-' . $y] = '';
            }
        }

        // dump($this->board);
    }

    public function getBoard() {
        return $this->board;
    }

    // Lorsqu'un board est créé, il est créé vide, on a besoin d'un méthode pour "générer" une map pleine, c'est à dire pour placer des bateaux sur le board.
    // la méthode generate est implémentée dans la classe Board car c'est le tableau qui "connaît" ses contraintes, ses règles, de placement des bateaux sur lui.
    public function generate() {
        // pour tous les bateaux à placer
        // pour chaque nom de type de bateau de la self::$shipList
        foreach (self::$shipList as $shipClass) {
            // à partir de chaque shipClass, je vais créer un ship
            $shipClassName = '\BattleShip\Models\Ships\\'.$shipClass;
            $ship = new $shipClassName;

            // placer le bateau
            $this->addShip($ship);
        }
    }

    // méthode qui va placer un bateau (placer correctement cad selon les regles du jeu
    // on va passer le bateau qui est à placer en paramètre (pourquoi ? parce qu'il y a différents types de bateaux, avec des caractéristiques diférentes)
    public function addShip($ship) {

        // Faire
        do {

            // - considérer le bateau comme "placé"
            $added = true;

            // - placer le bateau de façon aléatoire,
            // je place l'appel aux méthodes de placement dans le try
            // si l'une d'entre elle déclenche (avec throw) une erreur, c'est que le placement n'a pas bien marché, je le détecterai avec catch.
            try {
                // - les coordonnées c'est un chiffre random entre 1 et la taille du Board
                $ship->setLatStart(rand(1, self::WIDTH));
                $ship->setLongStart(rand(1, self::HEIGHT));
                // l'axe random, c'est au hasard entre les axes possibles
                $ship->setAxis(\BattleShip\Models\Ships\CoreShip::getRandomDirection());

            }
            catch (\Exception $e) {
                // var_dump($e->getMessage());
                // vérifier si le bateau est bien dans le board (si NON ça déclenchera une Exception)
                $added = false;
            }

            // Si on arrive ici, le bateau n'a détecté aucune erreur sur son placement
            // <===> il est placé correctement dans la carte
            // Il reste à vérifier s'il n'y a pas d'autre bateau déjà sur ces cases.
            // C'est l'objet Board qui peut le vérifier en allant regarder

            if($added) {
                // - vérifier si le placement est correct par rapport au board :
                // c-a-d tester toutes les contraintes : tester pour chaque case ou est positionné ce ship, si on y trouve déjà un ship.

                $listCoords = $ship->getCoords();
                // var_dump($ship);
                // var_dump($listCoords);

                // pour chaque case où doit être le ship,
                foreach ($listCoords as $coord => $shipName) {
                    // vérifier s'il y a déjà qqchose dans le board
                    if(!empty($this->board[$coord])) {
                        // dès qu'une contrainte n'est pas respectée, added passe à faux
                        $added = false;
                    }
                }
            }
        }
        // tant que c'est pas correct, on réessaye
        while (!$added);

        // ==> si on arrive ici, c'est qu'on a trouvé une position correcte
        // mettre à jour le board, pour placer le bateau dans les cases

        // contenu du Board au départ
        // [1-1] => ''
        // [1-2] => ''
        // [2-1] => ''
        // [2-2] => ''

        // contenu de listCoords
        // [1-1] => "Destroyer"
        // [2-1] => "Destroyer"
        //

        // après le merge :
        // [1-1] => 'Destroyer'
        // [1-2] => ''
        // [2-1] => 'Destroyer'
        // [2-2] => ''

        $this->board = array_merge($this->board, $listCoords);

        // ajouter le bateau à la liste de bateaux du board
        $this->boats[] = $ship;
    }

    public function isEmpty($coords) {
        return empty($this->board[$coords]);
    }
}
