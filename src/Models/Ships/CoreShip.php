<?php

namespace BattleShip\Models\Ships;

use BattleShip\Models\Board;

abstract class CoreShip {

    // Certaines caractéristiques dépendent directement du type de bateau :
    private $name;
    private $size;

    // caractéristiques de jeu : vont changer pour chaque bateau, selon comment on va jouer avec
    private $latStart;
    private $longStart;
    private $axis;

    private $nbTouch = 0;

    // propriété contien une règle du jeu, on peut donc s'y référer dans les méthodes
    private static $allowedAxis = ['vertical', 'horizontal'];


    /**
     * Get the value of Name
     *
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of Name
     *
     * @param mixed name
     *
     * @return self
     */
    protected function setName($name)
    {
        $this->name = $name;

        return true;
    }

    /**
     * Get the value of Size
     *
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set the value of Size
     *
     * @param mixed size
     *
     * @return self
     */
    protected function setSize($size)
    {
        $this->size = $size;

        return true;
    }

    /**
     * Get the value of Lat Start
     *
     * @return mixed
     */
    public function getLatStart()
    {
        return $this->latStart;
    }

    /**
     * Set the value of Lat Start
     *
     * @param mixed latStart
     *
     * @return self
     */
    public function setLatStart($latStart)
    {
        if(!is_int($latStart) || $latStart <= 0 || $latStart > Board::WIDTH) {
            throw new \Exception('coordonnée X invalide');
        }
        else {
            $this->latStart = $latStart;
        }

        return true;
    }

    /**
     * Get the value of Long Start
     *
     * @return mixed
     */
    public function getLongStart()
    {
        return $this->longStart;
    }

    /**
     * Set the value of Long Start
     *
     * @param mixed longStart
     *
     * @return self
     */
    public function setLongStart($longStart)
    {
        if(!is_int($longStart) || $longStart <= 0 || $longStart > Board::HEIGHT) {
            throw new \Exception('coordonnée Y invalide');
        }
        else {
            $this->longStart = $longStart;
        }
        return true;
    }

    /**
     * Get the value of Axis
     *
     * @return mixed
     */
    public function getAxis()
    {
        return $this->axis;
    }

    /**
     * Set the value of Axis
     *
     * @param mixed axis
     *
     * @return self
     */
    public function setAxis($axis)
    {
        // si la direction demandée ne fait pas partie des autorisées => erreur
        if(!in_array($axis, self::$allowedAxis)) {
            throw new \Exception('Axe non autorisé');
        }
        // si on a pas la taille ou pas les coordonnées initiales du bateau, on peut pas fixer sa direction
        if(is_null($this->size) || is_null($this->latStart) || is_null($this->longStart)) {
            throw new \Exception('Renseigner taille et coordonnées du bateau avant l\'axe');
        }
        // si la direction est verticale, et que (coordonnéeY + tailleBateau - 1) === dernierecase > taille de la board ==> erreur
        if($axis === 'vertical' && (($this->longStart + $this->size - 1) > Board::HEIGHT)) {
            throw new \Exception('Le bateau va dépasser de la Board en hauteur');
        }
        // si la direction est horizontale, et que (coordonnéeX + tailleBateau) > taille de la board ==> erreur
        if($axis === 'horizontal' && (($this->latStart + $this->size - 1) > Board::WIDTH)) {
            throw new \Exception('Le bateau va dépasser de la Board en largeur');
        }

        $this->axis = $axis;

        return true;
    }

    /**
     * Get the value of Nb Touch
     *
     * @return mixed
     */
    public function getNbTouch()
    {
        return $this->nbTouch;
    }

    /**
     * Set the value of Nb Touch
     *
     * @param mixed nbTouch
     *
     * @return self
     */
    public function setNbTouch($nbTouch)
    {
        $this->nbTouch = $nbTouch;

        return true;
    }

    public static function getRandomDirection() {
        return self::$allowedAxis[array_rand(self::$allowedAxis)];
    }

    public function getCoords() {
        $listCoords = [];

        // calculer la liste des cases ou est positionné ce ship
        // si axe vertical
        if($this->axis === 'vertical') {
            // cases occupées c'est : toujours le même X, Y++ jusqu'à Y + la taille du bateau
            for($y=$this->longStart; $y < $this->longStart + $this->size; $y++) {
                $listCoords[$this->latStart . '-' . $y] = $this->name;
            }
        }
        // si axe horizontal
        if($this->axis === 'horizontal') {
            // cases occupées == même Y, X varie ==> taille du bateau
            for($x=$this->latStart; $x < $this->latStart + $this->size; $x++) {
                $listCoords[$x . '-' . $this->longStart] = $this->name;
            }
        }

        return $listCoords;

    }
}
