<?php

include_once('Personnage.php');

$perso1 = new Personnage("Mario", 50);
$perso1->gagnerExperience()->parler();

$perso2 = new Personnage("Luigi", 40);
$perso2->gagnerExperience()->parler();

$perso1->frapper($perso2);
$perso2->parler();
