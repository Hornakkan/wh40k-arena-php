<?php

require_once("IUnit.php");

abstract class AMonster implements IUnit {
    protected $name;
    protected $hp = 0;
    protected $ap = 0;
    protected $damage = 0;
    protected $apcost = 0;

    public $inRange = NULL;
    protected $isDead = false;
    
    public function __construct($myName, $myHp = 0, $myAp = 0, $myDamage = 0, $myApcost = 0) {
        if(isset($myName)) {
            if(is_string($myName) && is_numeric($myHp) && is_numeric($myAp) && is_numeric($myDamage) && is_numeric($myApcost)) {
                $this->name = $myName;
                $this->hp = $myHp;
                $this->ap = $myAp;
                $this->damage = $myDamage;
                $this->apcost = $myApcost;
            } else {
                throw new Exception("Error in AMonster constructor. Bad parameters.");
            }
        }
    }

    // getters
    public function getName() {
        return $this->name;
    }

    public function getHp() {
        return $this->hp;
    }

    public function getAp() {
        return $this->ap;
    }

    public function getDamage() {
        return $this->damage;
    }

    public function getApcost() {
        return $this->apcost;
    }

    public function getIsDead() {
        return $this->isDead;
    }

    // methods
    public function equip($equipParam) {
        if($this->isDead == true) {
            return false;
        } else {
            echo "Monsters are proud and fight with their own bodies.\n";
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
                                    $attackUnit->receiveDamage($this->damage);
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

    public function receiveDamage($damageParam) {
        if($this->isDead == true) {
            return false;
        } else {
            if($damageParam >= $this->hp) {
                $this->hp -= $damageParam;
                $this->isDead = true;
                //$this->hp = 0;
            } else {
                $this->hp -= $damageParam;
            }
        }
    }

    public function moveCloseTo($moveParam) {
        if($this->isDead == true) {
            return false;
        } else {
            if(gettype($moveParam) === "object") {
                if($moveParam instanceof IUnit) {
                    if($moveParam != $this && $moveParam->getName() != $this->inRange) {
                        $this->inRange = $moveParam->getName();
                        //$moveParam->inRange = $this->getName();
                        echo $this->name . " is moving closer to " . $moveParam->getName() . ".\n";
                    }
                } else {
                    throw new Exception ("Error in AMonster. Parameter is not an IUnit.");
                }
            } else {
                throw new Exception ("Error in AMonster. Parameter is not an IUnit.");
            }
        }
    }

    public function recoverAP() {
        if($this->isDead == true) {
            return false;
        } else {
            if(($this->ap + 7) > 50) {
                $this->ap = 50;
            } else {
                $this->ap += 7;
            }
        }
    }

}