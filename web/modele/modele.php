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
        $valeurs = array("log" => $l);

        try{
            $requetePreparee->execute($valeurs);
        } catch(PDOException $e){
            echo $e->getMessage();
         }
        $requetePreparee->setFetchmode(PDO::FETCH_CLASS, get_called_class());
        $objets = $requetePreparee->fetchAll();
        return $objets;
    }

    public static function create($data) {
        $table = static::$objet;

        $colonnes = array_keys($data);
        $placeholders = array_map(function($col) {return ":$col";}, $colonnes);

        $sql =  $sql = "INSERT INTO $table (".implode(',', $colonnes).") VALUES (".implode(',', $placeholders).")";
        $stmt = connexion::pdo()->prepare($sql);

        try {
            $stmt->execute($data);
            return connexion::pdo()->lastInsertId();
        } catch (PDOException $e) {
            echo "Erreur lors de la création: " . $e->getMessage();
            return false;
        }
    }

    public static function update($id, $data) {
        $table = static::$objet;
        $cle = static::$cle;

        $sets = [];
        foreach ($data as $col => $val) {
            $sets[] = "$col = :$col";
        }
        $sql = "UPDATE $table SET ".implode(',', $sets)." WHERE $cle = :id";
        $stmt = connexion::pdo()->prepare($sql);
        $data['id'] = $id; 
        try {
            return $stmt->execute($data);
        } catch (PDOException $e) {
            echo "Erreur lors de la mise à jour: " . $e->getMessage();
            return false;
        }
    }

    public static function delete($id) {
        $table = static::$objet;
        $cle = static::$cle;

        $sql = "DELETE FROM $table WHERE $cle = :id";
        $stmt = connexion::pdo()->prepare($sql);
        try {
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            echo "Erreur lors de la suppression: " . $e->getMessage();
            return false;
        }
    }

    public static function getAllByColumn($column, $value) {
        $table = static::$objet;
        $sql = "SELECT * FROM $table WHERE $column = :val";
        $stmt = connexion::pdo()->prepare($sql);
        try {
            $stmt->execute(['val' => $value]);
            $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération: " . $e->getMessage();
            return [];
        }
    }

}