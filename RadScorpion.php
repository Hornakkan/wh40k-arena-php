<?php

require_once("AMonster.php");

class RadScorpion extends AMonster {
    static $countScorpion = 0;
    protected $idScorpion = 0;

    public function __construct() {
        self::$countScorpion++;
        $idScorpion = "RadScorpion #".self::$countScorpion;
        parent::__construct($idScorpion, 80, 50, 25, 8);
        echo $this->name . ": Crrr !\n";
    }

    public function __destruct() {
        if($this->isDead === false) {
            echo $this->name . ": SPROTCH !\n";
        }
    }

    //methods
    public function receiveDamage($damageParam) {
        if($this->isDead === true) {
            return false;
        } else {
            if($damageParam >= $this->hp) {
                $this->hp -= $damageParam;
                $this->isDead = true;
                echo $this->name . ": SPROTCH !\n";
                //$this->hp = 0;
            } else {
                $this->hp -= $damageParam;
            }
        }
    }

    public function attack($attackUnit) {
        if($this->isDead == true) {
            return false;
        } else {   
            if(gettype($attackUnit) === "object") {
                    if($attackUnit instanceof IUnit) {
                        if($attackUnit != $this) {
                        // do some attacks
                        if(isset($this->inRange) && $this->inRange == $attackUnit->getName()) {
                            // $inRange doit contenir l'unité avec laquelle le Monster est au contact
                            if($this->apcost <= $this->ap) {
                                // attaque réussie
                                //if($attackUnit->isDead == false) {
                                    $this->ap -= $this->apcost;
                                    echo $this->name . " attacks " . $attackUnit->getName() . ".\n";                                    
                                    if(get_class($attackUnit) != "TacticalMarine") {
                                        $attackUnit->receiveDamage($this->damage);
                                    } else {
                                        $attackUnit->receiveDamage($this->damage*2);
                                    }
                                //}
                            } else {
                                // attaque échouée
                            }
                        } else {
                            // sinon c'est qu'il en est trop éloigné
                            echo $this->name . ": I'm too far away from " . $attackUnit->getName() . ".\n";
                        }
                        }
                    } else {
                        throw new Exception ("Error in AMonster. Parameter is not an IUnit.");
                    }
            } else {
                throw new Exception ("Error in AMonster. Parameter is not an IUnit.");
            }
        }
    }


}