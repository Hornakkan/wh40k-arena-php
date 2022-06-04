<?php

require_once("AWeapon.php");

class PlasmaRifle extends AWeapon {

    public function __construct() {
        parent::__construct("Plasma Rifle", 5, 21, false);
    }

    public function attack() {
        echo "PIOU\n";
    }

}


// - PlasmaRifle :
//     - Name : "Plasma Rifle"
//     - Damage : 21
//     - AP cost : 5
//     - Output of attack() : “PIOU”
//     - Not Melee