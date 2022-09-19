<?php
require_once 'conf.php';

function chargerClasse($classe)
{
    require_once $classe . '.php';
}
spl_autoload_register('chargerClasse');


/*$perso1 = new Personnage("Mario", Personnage::FORCE_MOYENNE);
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
}*/



try {
    $options = array(
        PDO::MYSQL_ATTR_SSL_CA => "E:\\php\\cacert.pem",
    );
    $db = new PDO($dsn, $user, $password, $options);
    if ($db) {
        print('<br/>Lecture dans la base de données :');
        $request = $db->query('SELECT id, nom, `force`, degats, niveau, experience FROM personnages;');
        // Chaque entrée sera récupérée et placée dans un tableau (array).
        while ($ligne = $request->fetch(PDO::FETCH_ASSOC))
        {
            print('<br/>' . $ligne['nom'] . ' a ' . $ligne['force'] . ' de force, '
             . $ligne['degats'] . ' de dégâts, ' . $ligne['experience'] . ' d\'expérience et est au niveau'
             . $ligne['niveau']);
        }
    }
} catch (PDOException $e) {
    print('<br/>Erreur de connexion : ' . $e->getMessage());
}