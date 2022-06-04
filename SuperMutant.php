<?php

require_once("AMonster.php");

class SuperMutant extends AMonster {
    static $countMutant = 0;
    protected $idMutant = 0;

    public function __construct() {
        self::$countMutant++;
        $idMutant = "SuperMutant #".self::$countMutant;
        parent::__construct($idMutant, 170, 20, 60, 20);
        echo $this->name . ": Roaarrr !\n";
    }

    public function __destruct() {
        if($this->isDead === false) {
            echo $this->name . ": Urgh !\n";
        }
    }

    //methods
    public function receiveDamage($damageParam) {
        if($this->isDead == true) {
            return false;
        } else {
            if($damageParam >= $this->hp) {
                $this->hp -= $damageParam;
                echo $this->name . ": Urgh !\n";
                $this->isDead = true;
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
            if(($this->ap + 7) > 50) {
                $this->ap = 50;
            } else {
                $this->ap += 7;
            }

            if(($this->hp + 10) > 170) {
                $this->hp = 170;
            } else {
                $this->hp += 10;
            }
        }
    }
}