<?php

class Personnage {
    private $_id; // Son id
    private $_nom; // Son nom
    private $_force; // La force du personnage
    private $_experience; // Son exprience
    private $_pv; // Ses points de vie

    const FORCE_PETITE = 20;
    const FORCE_MOYENNE = 50;
    const FORCE_GRANDE = 80;

    const CEST_MOI = 1;
    const PERSONNAGE_TUE = 2;
    const PERSONNAGE_FRAPPE = 3;

    public function __construct(array $ligne) {
        $this->hydrate($ligne);
    }

    public function hydrate(array $ligne) {
        foreach ($ligne as $key => $value) {
            $mutateur = "set".ucfirst($key);
            if (method_exists($this, $mutateur)) {
            $this->$mutateur($value);
            }
        }
        print("</br>");
    }

    public function __toString() {
        return "</br>Je m'appelle " . $this->_nom 
        . " ma force est : " . intval($this->_force) . "</br>"
        . " mes points de vie sont : " . intval($this->_pv ) . "</br>"
        . " mon expérience est : " . intval($this->_experience) . "</br>";
    }

    // Nous déclarons une méthode dont le seul but 
    public function parler() 
    {
        print("Je suis le " . self::$_id++ . "ème personnage");
    }

    // Une méthode qui frappera un personnage ( suivant la force qu'il a )
    public function frapper(Personnage $adversaire) {
        $adversaire->setPv($adversaire->getPv() -  $this->getForce());
        print("<br/>".$this->getNom()." frappe ". $adversaire->getNom() . "</br>" . "</br>");
    }

    // Une méthode augmentant l'attribut $expérience du personnage
    public function gagnerExperience():Personnage
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
    public function setNom(string $nom)
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
        if (in_array($force, array(self::FORCE_PETITE, self::FORCE_MOYENNE, self::FORCE_GRANDE))) {
        $this->_force = $force;
        }
        else {
            $this->_force= 0;
        }
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
    public function setExperience(int $experience):Personnage
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
    public function setPv(int $pv):Personnage
    {
        $this->_pv = $pv;

        return $this;
    }

    /**
     * Get the value of _id
     */ 
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Set the value of _id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->_id = $id;

        return $this;
    }
}

