<?php

require_once("IUnit.php");
require_once("PowerFist.php");

abstract class ASpaceMarine implements IUnit {
    protected $name;
    protected $hp = 0;
    protected $ap = 0;
    protected $weapon = NULL;

    public $inRange = NULL;
    protected $isDead = false;    

    public function __construct($myName, $myHp = 0, $myAp = 0) {
        if(isset($myName)) {
            if(is_string($myName) && is_numeric($myHp) && is_numeric($myAp)) {
                $this->name = $myName;
                $this->hp = $myHp;
                $this->ap = $myAp;
            }else {
                // throw new Exception("Error in ASpaceMarine constructor. Bad parameters.");
            }
        }
    }    

    //getters
    public function getName() {
        return $this->name;
    }

    public function getHp() {
        return $this->hp;
    }

    public function getAp() {
        return $this->ap;
    }

    public function getWeapon() {
        return $this->weapon;
    }

    public function getIsDead() {
        return $this->isDead;
    }

    //methods
    public function equip($equipParam) {
        if($this->isDead == true) {
            return false;
        } else {    
            if(gettype($equipParam) === "object") {
                if(get_parent_class($equipParam) === "AWeapon" ) {
                    //équiper l'arme
                    if($equipParam->getOwner() === NULL) {
                        $equipParam->setOwner($this);
                        if(isset($this->weapon)) {
                            $this->weapon->setOwner(NULL);
                        }
                        $this->weapon = $equipParam;
                        echo $this->name . " has been equipped with a " . $equipParam->getName() . ".\n";
                    } else {
                        //echo $this->name . " can't equip this weapon. It's already been equipped by " . $equipParam->getOwner() . "\n";
                        $this->weapon = new BareHand();
                    }
                } else {
                    throw new Exception("Error in ASpaceMarine. Parameter is not an AWeapon");
                }
            } else {
                throw new Exception("Error in ASpaceMarine. Parameter is not an AWeapon");
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
                        if(isset($this->weapon) && $this->weapon->getName() != "Bare Hand") {
                            if($this->weapon->isMelee() === true) {
                                //arme de melee
                                if(isset($this->inRange) && $this->inRange == $attackUnit->getName()) {
                                    // $inRange doit contenir l'unité avec laquelle le Space Marine est au contact
                                    if($this->weapon->getApcost() <= $this->ap) {
                                        // attaque réussie
                                        //if($attackUnit->isDead == false) {
                                            $this->ap -= $this->weapon->getApcost();
                                            echo $this->name . " attacks " . $attackUnit->getName() . " with a " . $this->weapon->getName() . ".\n";
                                            $this->weapon->attack();
                                            $attackUnit->receiveDamage($this->weapon->getDamage());
                                        //}
                                    } else {
                                        // attaque échouée
                                    }
                                } else {
                                    // sinon c'est qu'il en est trop éloigné
                                    echo $this->name . ": I'm too far away from " . $attackUnit->getName() . ".\n";
                                }
                            } else {
                                //arme ranged
                                if($this->weapon->getApcost() <= $this->ap) {
                                    // attaque réussie
                                    //if($attackUnit->isDead == false) {
                                        $this->ap -= $this->weapon->getApcost();
                                        echo $this->name . " attacks " . $attackUnit->getName() . " with a " . $this->weapon->getName() . ".\n";
                                        $this->weapon->attack();
                                        $attackUnit->receiveDamage($this->weapon->getDamage());
                                    //}
                                } else {
                                    // attaque échouée
                                }
                            }

                        } else {
                            echo $this->name . ": Hey, this is crazy. I'm not going to fight this empty handed.\n";
                        }
                    }
                } else {
                    throw new Exception ("Error in ASpaceMarine. Parameter is not an IUnit.");
                }
            } else {
                throw new Exception ("Error in ASpaceMarine. Parameter is not an IUnit.");
            }
        }
    }

    public function receiveDamage($damageParam) {
        if($this->isDead == true) {
            return false;
        } else {
            if($damageParam >= $this->hp) {
                $this->isDead = true;
                $this->hp -= $damageParam;
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
                    throw new Exception ("Error in ASpaceMarine. Parameter is not an IUnit.");
                }
            } else {
                throw new Exception ("Error in ASpaceMarine. Parameter is not an IUnit.");
            }
        }
    }

    public function recoverAP() {
        if($this->isDead === true) {
            return false;
        } else {
            if(($this->ap + 9) > 50) {
                $this->ap = 50;
            } else {
                $this->ap += 9;
            }
        }
    }

}