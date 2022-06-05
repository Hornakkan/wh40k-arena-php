# wh40k-arena-php

Enlist your team of Monsters and your team of Space Marines and watch them fight until victory.
The remaining fighters will stay in the arena and be ready for another fight.

The rules are as follow : 
- monsters will always be melee fighters
- Tactical Marines will be equiped with a Plasma Rifle and thus can shoot from afar
- Assault Terminator will be equiped with Power fist, so they'll have to be ine melee to fight
- Exceptions will be thrown if you try to enlist anything but monsters in the enlisMonsters method
- Exceptions will be thrown if you try to enlist anything but space marines in the enlisMarines method
- If no monsters are registered it will say : No monster available to fight.
- If no spaceMarines are registered it will say : Those cowards ran away.

Here is how a fight should proceed:
- When a new round between a monster and spaceMarine begin, the spaceMarine always go first.
- The one playing will try to attack, if it’s a success their turn is over. If it failed because they weren’t in range,
they will go closer. If it failed because they didn’t have enough AP, they will call their method “recoverAP”
once.
- The turn then goes to the opponent. This process repeats until one of the opponent has fallen. The winner
call their function “recoverAP” once before starting their next fight.
- If the spaceMarine has won, the second monster comes in the arena, and the whole process starts again
until one of the two teams has been defeated (If the monster has won, then second spaceMarine enters
the fray).

At the end of the fight, the victorious team will be announced like this : The [team’s name] are victorious.
Where [team’s name] will be replaced by “monsters” or “spaceMarines”.



You can use this example below to initiate your first fights : 


include_once("SpaceArena.php");\n
$arena = new SpaceArena();
$arena->enlistMonsters([new RadScorpion(), new SuperMutant(), new RadScorpion()]);
$arena->enlistSpaceMarines([new TacticalMarine("Joe"), new AssaultTerminator("Abaddon"), new TacticalMarine("Rose")]);
$arena->fight();
$arena->enlistMonsters([new SuperMutant(), new SuperMutant()]);
$arena->fight();
