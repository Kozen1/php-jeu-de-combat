<?php 
// Chargement de l'autoload(Pile d'execution de class a charger)
require_once('conf.php');

function chargerClasse($classe)
{
    require_once $classe . '.php';
}
spl_autoload_register('chargerClasse');

// Page Index, Creation des personnage ($personnage = new Personnage())
// Affichage du plan de jeux(combat, victoire ou defaite)

// On appel session_start après avoir enregistré l'autoloader
session_start();

if(isset($_GET['deconnexion'])) {
  session_destroy();
  header('Location: .');
  exit();

}
// SI la session du personnage existe on restaure l'objet
if(isset($_SESSION['perso'])) {
  $personnages = $_SESSION['perso'];

}

try {
  $options = array(
    PDO::MYSQL_ATTR_SSL_CA => "E:\\php\\cacert.pem",
  );
  $db = new PDO($dsn, $user, $password, $options);
  $pm = new PersonnagesManager($db);
}
catch (PDOException $e) {
    print('<br/>Erreur de connexion : ' . $e->getMessage());
}

// SI on a voulu créer un personnage
if(isset($_POST['creer']) && isset($_POST['nom'])) {
  // On créer un nouveau personnage
  $perso = new Personnage(['nom' => $_POST['nom']]);

//   if($perso->personnagesExists($perso->nom())) {

//     $message = 'Le nom du personnage est déjà pris.';
//     unset($perso);
//   }
//   else {

//     $manager->add($perso);
//   //}
// } // EOF if
}
// Si on veut utiliser ce personnage
elseif(isset($_POST['utiliser']) && isset($_POST['nom'])) {
  // Si le personnage existe
  if($manager->personnagesExists($_POST['nom'])) {
    $personnages = $manager->getBdd($_POST['nom']);
  } 
  else {
    // Si le personnage n'existe pas, on affiche un message
    $message = 'Ce personnage n\'existe pas !';
  }
} // EOF elseif[utiliser]

elseif(isset($_GET['frapper'])) { // Si on a cliquer sur une personnage pour le frapper
  if(!isset($personnages)) {
    $message = 'Merci de créer un personnage ou de vous identifier.';

  }
  else {
    if(!$manager->exists((int) $_GET['frapper'])) {

      $message = 'Le personnage que vous voulez frapper n\'existe pas !';
    }
    else {
      $personnageAFrapper = $manager->get((int) $_GET['frapper']);

      // On stock dans $messageRetour les éventuelles erreurs ou messages que renvoie la méthode frapper
      $messageRetour = $personnages->frapper($personnageAFrapper);

      switch($messageRetour) {
        case Personnages::CEST_MOI :
        $message = 'Mais ? mais ? je ne comprend pas pourquoi tu veut te frapper ??!!';
        break;

        case Personnages::COUP_PERSONNAGE :
        $message = 'Le coup à été porter avec succès !';

        $manager->update($personnages);
        $manager->update($personnageAFrapper);
        break;

        case Personnages::MORT_PERSONNAGE :
        $message = 'Félicitation ! Vous avez tuer ce personnage !';

        $manager->update($personnages);
        $manager->update($personnageAFrapper);

        break;

      } // EOF switch($messageRetour)
    } // EOF else $personnageAFrapper
  } // EOF else[existe]
} // EOF elseif[frapper]

?>
<!DOCTYPE html>
<html>
  <head>
    <title>RPG PHP</title>
    <meta charset='utf_8'/>
  </head>
  <body>
    <p>Nombre de personnages créer : <?php //echo $manager->count() ?></p>
    <?php 
      // Avons nous un message a afficher ?
      if(isset($message)) {
        // SI oui on l'affiche
        echo '<p>', $message ,'</p>';
      }

      // Si on utilise un personnage nouveau ou existant
      if(isset($personnages)) {
    ?>
      <p><a href='?deconnexion=1'>Déconnexion</a></p>
      <fieldset>
        <legend>Mes informations</legend>
        <!--Affichage des infos sur le personnage -->
        <p>
          Nom : <?php echo htmlspecialchars($personnages->nom()) ?><br/>
          Niveau : <?php echo $personnages->niveau() ?><br/>
          Experiences : <?php echo $personnages->experiences() ?><br/>
          Force du personnage : <?php echo $personnages->forcePersonnage() ?><br/>
          Vitalité du personnage : <?php echo $personnages->vitalitePersonnage() ?><br/>
          Dégats du personnage : <?php echo $personnages->degats() ?><br/>
        </p>
      </fieldset>
      <fieldset>
        <legend>Qui frapper ?</legend>
        <p>
          <?php 
          $personnage = $manager->getList($personnages->nom());

          if(empty($personnage)) {
            echo ' Personne a frapper !';
          }
          else {
            foreach($personnage as $unPersonnage)
              echo '<a href="?frapper=', $unPersonnage->id(), '">', htmlspecialchars($unPersonnage->nom()), 
              '</a> (dégâts : ', $unPersonnage->degats(), ')<br/>';
          }
          ?>
        </p>
      </fieldset>
      <?php
       } else
       
       {
      ?>
    <form action="" method="post">
      <p>
        Nom : <input type='text' name='nom' maxlength ='30'/>
        <input type='submit' value='Créer ce personnage' name='creer'/>
        <input type='submit' value='Utiliser ce personnage' name='utiliser'/>
      </p>
    </form>
    <?php 
       }
    ?>
  </body>
</html>
<?php
  // SI on créer un personnage, on le stock dans une variable de session afin d'économiser une requête SQL
  if(isset($personnages)) {
    $_SESSION['perso'] = $personnages;
  }
?>
