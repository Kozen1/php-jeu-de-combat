<?php

class PersonnagesManager {
    private $_db;

    public function __construct($db) {
        $this->setDb($db);
    }

    public function add(Personnage $perso) {
        $request = $this->_db->prepare('INSERT INTO personnages SET nom = :nom,
            `force` = :force,  pv = :pv, experience = :experience;');

            $request->bindValue(':nom', $perso->getNom(), PDO::PARAM_STR);
            $request->bindValue(':force', $perso->getForce(), PDO::PARAM_STR);
            $request->bindValue(':pv', $perso->getPv(), PDO::PARAM_STR);
            $request->bindValue(':experience', $perso->getExperience(), PDO::PARAM_STR);

        $request->execute();

        if ($request->errorCode() > 0) {
            echo "<br/>Une erreur SQL est intervenue : ";
            print_r($request->errorInfo()[2]);
        }
    }

    public function delete(Personnage $perso) {

    }
    public function getOne($id){

    }
    public function getList(){
        
    }
    public function update(Personnage $perso){
        
    }
    public function setDb(PDO $db){
        $this->_db = $db;
    }
}
