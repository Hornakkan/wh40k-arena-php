<?php

require_once("AWeapon.php");

class PowerFist extends AWeapon {

    public function __construct() {
        parent::__construct("Power Fist", 8, 50, true);
    }

    public function attack() {
        echo "SBAM\n";
    }

}

class BareHand extends AWeapon {

    public function __construct() {
        parent::__construct("Bare Hand", 0, 0, true);
    }

    public function attack() {
        return "SBAM";
    }

}


// - PowerFist :
//     - Name : “Power Fist”
//     - Damage : 50
//     - AP cost : 8
//     - Output of attack() : “SBAM”
//     - Melee