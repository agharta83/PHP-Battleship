<?php

namespace BattleShip\Models\Ships;


class Cruiser extends CoreShip {

    public function __construct() {
        $this->setName('Cruiser');
        $this->setSize(3);
    }

}
