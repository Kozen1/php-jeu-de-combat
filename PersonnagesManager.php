<?php

class PersonnagesManager
{
    private $_db;

    public function __construct($db)
    {
        $this->setDb($db);
    }

    public function add(Personnage $perso)
    {
        $request = $this->_db->prepare('INSERT INTO personnages SET nom = :nom,
            `force` = :force,  pv = :pv, experience = :experience;');

        $request->bindValue(':nom', $perso->getNom(), PDO::PARAM_STR);
        $request->bindValue(':force', $perso->getForce(), PDO::PARAM_INT);
        $request->bindValue(':pv', $perso->getPv(), PDO::PARAM_INT);
        $request->bindValue(':experience', $perso->getExperience(), PDO::PARAM_INT);

        $request->execute();

        print("Le personnage est ajouté");

        if ($request->errorCode() > 0) {
            echo "<br/>Une erreur SQL est intervenue : ";
            print_r($request->errorInfo()[2]);
        }
    }

    public function delete(Personnage $perso)
    {
        //$this->_db->exec('DELETE FROM personnages WHERE id = '.$perso->getId().';');
        $request = $this->_db->prepare('DELETE FROM personnages WHERE id = :id;');
        $request->bindValue(':id', $perso->getId(), PDO::PARAM_INT);
        $request->execute();
        if ($request->errorCode() > 0) {
            echo "<br/>Une erreur SQL est intervenue : ";
            print_r($request->errorInfo()[2]);
        }
    }

    public function getOne($id)
    {
        $id = (int) $id;

        $request = $this->_db->prepare('SELECT id, nom, `force`, pv, experience FROM personnages WHERE id = :id;');
        $request->bindValue(':id', $id, PDO::PARAM_INT);
        $request->execute();

        if ($request->errorCode() > 0) {
            echo "<br/>Une erreur SQL est intervenue : ";
            print_r($request->errorInfo()[2]);
        }
        $ligne = $request->fetch(PDO::FETCH_ASSOC);
        return new Personnage($ligne);
    }

    public function getList(): array
    {
        $persos = array();
        $request = $this->_db->query('SELECT id, nom, `force`, pv, experience FROM personnages;');

        while ($ligne = $request->fetch(PDO::FETCH_ASSOC))
        {
            $persos[] = new Personnage($ligne);
        }
        return $persos;
    }

    public function update(Personnage $perso)
    {
    }

    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }
}
