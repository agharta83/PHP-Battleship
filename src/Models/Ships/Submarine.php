<?php

namespace BattleShip\Models\Ships;


class Submarine extends CoreShip {

    public function __construct() {
        $this->setName('Submarine');
        $this->setSize(3);
    }

}
