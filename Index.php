<?php

function chargerClasse($classe)
{
    require $classe . '.php';
}
spl_autoload_register('chargerClasse');


$perso1 = new Personnage("Mario", Personnage::FORCE_MOYENNE);
$perso2 = new Personnage("Luigi", Personnage::FORCE_PETITE);

$personnages = array('Joueur1'=>$perso1, 'Joueur2'=>$perso2);

foreach ($personnages as $personnage) {
    print($personnage);
    $personnage->gagnerExperience()->parler();
}

$perso1->frapper($perso2);

foreach ($personnages as $personnage) {
    print($personnage);
    $personnage->parler();
}
