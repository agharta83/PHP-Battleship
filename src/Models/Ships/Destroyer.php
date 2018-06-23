<?php

namespace BattleShip\Models\Ships;


class Destroyer extends CoreShip {

    public function __construct() {
        $this->setName('Destroyer');
        $this->setSize(2);
    }

}
