<?php

require_once("SuperMutant.php");
require_once("RadScorpion.php");
require_once("TacticalMarine.php");
require_once("AssaultTerminator.php");

class SpaceArena {
    static $marineArray;
    static $monsterArray;
    protected $enlistedMonsters = [];
    protected $enlistedMarines = [];

    public function __construct() {
        //
    }

    public function __destruct() {
        //
    }
    
    //methods
    public function enlistMonsters($monstersArray) {
        foreach($monstersArray as $monster) {
            if(gettype($monster) === "object") {
                if(get_parent_class($monster) === "AMonster") {
                    // vérifier que le Monster n'est pas déjà enlisted
                    // sinon l'ajouter
                    if(in_array($monster, $this->enlistedMonsters) === false) {
                        array_push($this->enlistedMonsters, $monster);
                    }
                } else {
                    throw new Exception("Stop trying to cheat!");
                    return;
                }
            } else {
                throw new Exception("Stop trying to cheat!");
                return;
            }
        }
    }

    public function enlistSpaceMarines($marinesArray) {
        foreach($marinesArray as $marine) {
            if(gettype($marine) === "object") {
                if(get_parent_class($marine) === "ASpaceMarine") {
                    // vérifier que le Marine n'est pas déjà enlisted
                    // sinon l'ajouter
                    if(in_array($marine, $this->enlistedMarines) === false) {
                        array_push($this->enlistedMarines, $marine);
                    }
                } else {
                    throw new Exception("Stop trying to cheat!");
                    return;
                }
            } else {
                throw new Exception("Stop trying to cheat!");
                return;
            }
        }
    }

    public function fight() {
        
        // récupérer les gagnants issus d'un précédent combat
        // puis vider les tableaux statique en prévision du nouveau combat
        $nbStaticMonster = (isset(self::$monsterArray)) ? count(self::$monsterArray) : 0;
        $nbStaticMarine = (isset(self::$marineArray)) ?count(self::$marineArray) : 0;
        
        if($nbStaticMonster > 0) {
            foreach(self::$monsterArray as $monsterS) {
                array_push($this->enlistedMonsters, $monsterS);
            }
        }

        if($nbStaticMarine > 0) {
            foreach(self::$marineArray as $marineS) {
                array_push($this->enlistedMarines, $marineS);
            }
        }
        
        self::$monsterArray = [];
        self::$marineArray = [];


        // préparation du nouveau combat
        $nbMonsters = count($this->enlistedMonsters);
        $nbMarines = count($this->enlistedMarines);      
            
        if(empty($this->enlistedMonsters)) {
            echo "No monster available to fight.\n";
            return false;
        } else if(empty($this->enlistedMarines)) {
            echo "Those cowards ran away.\n";
            return false;
        } else {
            // initialisation du premier combat
            $marine = $this->enlistedMarines[0];
            $monster = $this->enlistedMonsters[0];
            echo $marine->getName() . " has entered the arena.\n";
            echo $monster->getName() . " has entered the arena.\n";

            // déroulement des combats
            // s'arrêter lorsque l'on n'a plus de $marine ou de $monster
            while($nbMonsters>0 && $nbMarines>0) {
                begin:
                // tour du $marine
                if($marine->getWeapon()->isMelee() === true) {
                    // arme de melee
                    if(isset($marine->inRange) && $marine->inRange === $monster->getName()) {
                        // à portée du $monster
                        if($marine->getAp() >= $marine->getWeapon()->getApcost()) {
                            // assez de AP pour attaquer
                            $marine->attack($monster);
                        } else {
                            // pas assez de AP pour attaquer
                            $marine->recoverAP();
                        }
                    } else {
                        // pas à portée du $monster
                        $marine->attack($monster);
                        $marine->moveCloseTo($monster);
                    }
                } else {
                    // arme à distance, pas besoin de vérifier inRange
                    // vérifier le nombre de AP
                    if($marine->getAp() >= $marine->getWeapon()->getApcost()) {
                        // assez de AP pour attaquer
                        $marine->attack($monster);
                    } else {
                        // pas assez de AP pour attaquer
                        $marine->recoverAP();
                    }
                }

                // vérifier si le $monster est mort
                if($monster->getIsDead() === true) {                    
                    if(count($this->enlistedMonsters) == 1) {
                        // le dernier $monster vivant est mort
                        foreach($this->enlistedMonsters as $aliveMarine) {
                            array_push(self::$monsterArray, $aliveMarine);
                        }
                        echo "The spaceMarines are victorious.\n";
                        $this->enlistedMonsters = [];
                        return false;
                    } else {
                        // il reste des $monster en vie, le $monster actuel est mort
                        // je supprime la première entrée du tableau des monsters
                        array_shift($this->enlistedMonsters);
                        $marine->recoverAP();
                        $nbMonsters--;
                        echo $this->enlistedMonsters[0]->getName() . " has entered the arena.\n";
                        unset($monster);
                        $monster = $this->enlistedMonsters[0];
                        // l'ancien $monster est mort, je lance le prochain combat
                        // en commençant par le $marine
                        goto begin;                        
                    }                    
                }


                // tour du $monster
                if(isset($monster->inRange) && $monster->inRange === $marine->getName()) {
                    // à portée du $marine
                    if($monster->getAp() >= $monster->getApcost()) {
                        // assez de AP pour attaquer
                        $monster->attack($marine);
                    } else {
                        // pas assez de AP pour attaquer
                        $monster->recoverAP();
                        // $monster->attack($marine);
                    }
                } else {
                    // pas à portée du $marine
                    $monster->attack($marine);
                    $monster->moveCloseTo($marine);
                }

                // vérifier si le $marine est mort
                if($marine->getIsDead() === true) {
                    if(count($this->enlistedMarines) == 1) {
                        // le dernier $marine vivant est mort
                        foreach($this->enlistedMonsters as $aliveMonster) {
                            array_push(self::$monsterArray, $aliveMonster);
                        }
                        echo "The monsters are victorious.\n";
                        $this->enlistedMarines = [];
                        return false;
                    } else {
                        // il reste des $marines en vie, le $marine actuel est mort
                        // je supprime la première entrée du tableau des marines
                        array_shift($this->enlistedMarines);
                        $monster->recoverAP();
                        $nbMarines--;
                        echo $this->enlistedMarines[0]->getName() . " has entered the arena.\n";                        
                        unset($marine);
                        $marine = $this->enlistedMarines[0];
                    }
                }                
            }
        }    
    }


}