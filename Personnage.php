<?php

class Personnage {
    private $_nom; // Son nom
    private $_force; // La force du personnage
    private $_experience; // Son exprience
    private $_pv; // Ses points de vie

    public function __construct(string $nom, string $force) {
        $this->_nom = $nom;
        $this->setPv(100);
        $this->setForce($force);
        $this->setExperience(0);
    }

    // Nous déclarons une méthode dont le seul but 
    public function parler() 
    {
        print("</br>Je m'appelle " . ($this->_nom) 
        . " ma force est : " . intval($this->_force) . "</br>"
        . " mes points de vie sont : " . intval($this->_pv ) . "</br>"
        . " mon expérience est : " . intval($this->_experience) . "</br>"
        . "</br>". "</br>");

        return $this;
    }

    // Une méthode qui frappera un personnage ( suivant la force qu'il a )
    public function frapper(Personnage $adversaire) {
        $adversaire->setPv($adversaire->getPv() -  $this->getForce());
        print("<br/>".$this->getNom()." frappe ". $adversaire->getNom());
    }

    // Une méthode augmentant l'attribut $expérience du personnage
    public function gagnerExperience() 
    {
        $this->setExperience($this->getExperience() + 1);

        return $this;
    }

    /**
     * Get the value of _nom
     */ 
    public function getNom()
    {
        return $this->_nom;
    }

    /**
     * Set the value of _nom
     *
     * @return  self
     */ 
    public function set_nom(string $nom)
    {
        $this->_nom = $nom;

        return $this;
    }

    /**
     * Get the value of _force
     */ 
    public function getForce()
    {
        return $this->_force;
    }

    /**
     * Set the value of _force
     *
     * @return  self
     */ 
    public function setForce(int $force)
    {
        $this->_force = $force;

        return $this;
    }

    /**
     * Get the value of _experience
     */ 
    public function getExperience()
    {
        return $this->_experience;
    }

    /**
     * Set the value of _experience
     *
     * @return  self
     */ 
    public function setExperience(int $experience)
    {
        $this->_experience = $experience;

        if ($this->_experience > 100) {
            $this->_experience = 100;
        }

        return $this;
    }

    /**
     * Get the value of _pv
     */ 
    public function getPv()
    {
        return $this->_pv;
    }

    /**
     * Set the value of _pv
     *
     * @return  self
     */ 
    public function setPv(int $pv)
    {
        $this->_pv = $pv;

        return $this;
    }
}

