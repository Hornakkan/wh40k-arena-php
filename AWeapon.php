<?php

abstract class AWeapon {
    protected string $name;
    protected int $apcost;
    protected int $damage;
    protected bool $melee;

    protected $owner = NULL;

    abstract public function attack();

    public function __construct($myName, $myApcost, $myDamage, $myMelee = false) {
            // if(isset($myName) && isset($myApcost) && isset($myDamage) && isset($myMelee)) {
                if(is_string($myName) && is_numeric($myApcost) && is_numeric($myDamage) && is_bool($myMelee)) {
                    $this->name = $myName;
                    $this->apcost = $myApcost;
                    $this->damage = $myDamage;
                    $this->melee = $myMelee;
                } else {
                    throw new Exception("Error in AWeapon constructor. Bad parameters.");
                }
            // } else {
            //     throw new Exception("Error in AWeapon constructor. Bad parameters.");
            // }
    }

    //setters
    public function setOwner($ownerParam) {
        $this->owner = $ownerParam;
    }

    // getters
    public function getName() {
        return $this->name;
    }

    public function getApcost() {
        return $this->apcost;
    }

    public function getDamage() {
        return $this->damage;
    }

    public function isMelee() {
        return $this->melee;
    }

    public function getOwner() {
        if(isset($this->owner)) {
            return $this->owner->getName();
        } else {
            return NULL;
        }
    }

}