<?php
class modele {
    //getter générique 
    public function get($attribut){
        return $this->$attribut;
    }

    //setter générique
    public function set($attribut, $valeur){$this->$attribut = $valeur;}

    //constructeur générique
    public function __construct($donnees = NULL){
        if (!is_null($donnees)){
            foreach($donnes as $attribut => $valeur){
                $this->set($attribut,$valeur);
            }
        }
    }

    public static function getAll(){
        $table = static::$objet;
        $requete = "SELECT * FROM $table;";
        $resultat = connexion::pdo()->query($requete);
        $resultat->setFetchmode(PDO::FETCH_CLASS, $table);
        $lesObjets = $resultat->fetchAll();
        return $lesObjets;
    }

    public static function getObjetById($l){
        $table = static::$objet;
        $cle = static::$cle;

        $requeteAvecTags = "SELECT * FROM $table WHERE $cle = :log;";
        $requetePreparee = connexion::pdo()->prepare($requeteAvecTags);
        $valeurs = array();
        $valeurs["log"] = $l;
        try{
        $requetePreparee->execute($valeurs);
        } catch(PDOException $e){
            echo $e->getMessage();
         }
        $requetePreparee->setFetchmode(PDO::FETCH_CLASS, $table);
        $utilisateur = $requetePreparee->fetchAll();
        return $utilisateur;
    }
}