<?php

require_once("ASpaceMarine.php");
require_once("PlasmaRifle.php");

class TacticalMarine extends ASpaceMarine {

    public function __construct($myName, $myHp = 100, $myAp = 20) {
        if(isset($myName)) {
            if(is_string($myName) && is_numeric($myHp) && is_numeric($myAp)) {
                parent::__construct($myName, $myHp, $myAp);
                echo $this->name . " on duty.\n";
                $this->equip(new PlasmaRifle());
            }else {
                // throw new Exception("Error in ASpaceMarine constructor. Bad parameters.");
            }
        }
    }
    
    public function __destruct() {
        //if($this->isDead === false) {
            echo $this->name . " the Tactical Marine has fallen !\n";
        //}
    }

    //methods
    public function receiveDamage($damageParam) {
        if($this->isDead == true) {
            return false;
        } else {
            if($damageParam >= $this->hp) {
                $this->hp -= $damageParam;
                $this->isDead = true;
                //echo $this->name . " the Tactical Marine has fallen !\n";
                //$this->hp = 0;
            } else {
                $this->hp -= $damageParam;
            }
        }
    }

    public function recoverAP() {
        if($this->isDead == true) {
            return false;
        } else {
            if(($this->ap + 12) > 50) {
                $this->ap = 50;
            } else {
                $this->ap += 12;
            }
        }
    }
}