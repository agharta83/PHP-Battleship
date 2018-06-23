<?php

namespace BattleShip\Models\Ships;


class Carrier extends CoreShip {

    public function __construct() {
        $this->setName('Carrier');
        $this->setSize(5);
    }

}
