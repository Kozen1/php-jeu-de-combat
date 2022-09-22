<?php
require_once 'conf.php';

function chargerClasse($classe)
{
    require_once $classe . '.php';
}
spl_autoload_register('chargerClasse');

try {
    $options = array(
        PDO::MYSQL_ATTR_SSL_CA => "E:\\php\\cacert.pem",
    );
    $db = new PDO($dsn, $user, $password, $options);
    if ($db) {
        $pm = new PersonnagesManager($db);
        // $perso4 = new Personnage(array('nom' => 'Bart', 'force' => 50, 'pv' => 140, 'experience' => 0));
        // $pm->add($perso4);
    }
} catch (PDOException $e) {
    print('<br/>Erreur de connexion : ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Tableau des scores</title>
    <meta charset="utf-8">
</head>

<body>
    <?php
    print('Je suis ' . $_POST["nom"]. ' . ');
    $perso = new Personnage(array( 'nom'=>$_POST["nom"], 'force'=>50, 'pv'=>100, 'experience'=>1 ));
    $pm->add($perso);
    $personnages = $pm->getList();
    foreach ($personnages as $personnage) {
        if ($_POST["nom"] != $personnage->getNom()) {
            print 'Nom : ' . $personnage->getNom() . '<br>';
            print 'Pv : ' . $personnage->getPv() . '<br>';
        }        
    }
    
    ?>
</body>

</html>