<?php

require_once("ASpaceMarine.php");
require_once("PowerFist.php");

class AssaultTerminator extends ASpaceMarine {

    public function __construct($myName, $myHp = 150, $myAp = 30) {
        if(isset($myName)) {
            if(is_string($myName) && is_numeric($myHp) && is_numeric($myAp)) {
                parent::__construct($myName, $myHp, $myAp);
                echo $this->name . " has teleported from space.\n";
                $this->equip(new PowerFist());
            }else {
                // throw new Exception("Error in ASpaceMarine constructor. Bad parameters.");
            }
        }
    }
    
    public function __destruct() {
        //if($this->isDead === false) {
            echo "BOUUUMMMM ! " . $this->name . " has exploded.\n";
        //}
    }

    //methods

    public function receiveDamage($damageParam) {
        if($this->isDead === true) {
            return false;
        } else {
            
            if(($damageParam - 3) >= 1) {
                $damageParam -= 3;
            } else {
                $damageParam = 1;
            }

            if($damageParam >= $this->hp) {
                $this->isDead = true;
                //$this->hp = 0;
                $this->hp -= $damageParam;
                //echo "BOUUUMMMM ! " . $this->name . " has exploded.\n";
            } else {
                $this->hp -= $damageParam;
            }
        }
    }

}