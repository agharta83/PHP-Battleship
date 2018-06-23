<?php

namespace BattleShip\Models\Ships;


class Battleship extends CoreShip {

    public function __construct() {
        $this->setName('Battleship');
        $this->setSize(4);
    }

}
