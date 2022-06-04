<?php

interface IUnit {
    public function equip($equipParam);
    public function attack($attackParam);
    public function receiveDamage($damageParam);
    public function moveCloseTo($moveParam);
    public function recoverAP();
}