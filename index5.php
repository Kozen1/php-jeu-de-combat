<?php
session_start();
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
        $pm = new PersonnagesManager($db);
        // $perso4 = new Personnage(array('nom' => 'Bart', 'force' => 50, 'pv' => 140, 'experience' => 0));
        // $pm->add($perso4);

?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Document</title>
        </head>

        <body>

            <form action="Recap.php" method="post">
                <div>
                    Nom : <input type="text" name="nom" />
                    <input type="submit" value="Créer ce personnage" name="creer" />
                </div>
            </form>

            <table border=1>
                <tr>
                    <th>Id</th>
                    <th>Nom</th>
                    <th>Force</th>
                    <th>Expérience</th>
                    <th>Pv</th>
                </tr>

                <tr>
                    <?php
                    $personnages = $pm->getList();
                    foreach ($personnages as $personnage) {
                        print('<tr>');
                        print('<td>' . $personnage->getId() . '</td>');
                        print('<td>' . $personnage->getNom() . '</td>');
                        print('<td>' . $personnage->getForce() . '</td>');
                        print('<td>' . $personnage->getExperience() . '</td>');
                        print('<td>' . $personnage->getPv() . '</td>');
                        print('/<tr>');
                    }
                    ?>
                </tr>
            </table>
        </body>

        </html>

<?php

    }
} catch (PDOException $e) {
    print('<br/>Erreur de connexion : ' . $e->getMessage());
}
