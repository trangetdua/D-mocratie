<?php
require_once('modele.php');

class Membre extends modele {
    protected static $objet = 'membre';
    protected static $cle = null; //composite key

    public static function getMembreById($idUtilisateur, $idUtilisateur) {
        $table = static::$objet;
        $sql = "SELECT * FROM $table WHERE Id_Utilisateur = :idu AND Id_Groupe = :idg";
        $stmt = connexion::pdo()->prepare($sql);
        $stmt->execute(['idu' => $idUtilisateur, 'idg' => $idGroupe]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        return $stmt->fetch();
    }

    public static function deleteMembre($idUtilisateur, $idGroupe) {
        $table = static::$objet;
        $sql = "DELETE FROM $table WHERE Id_Utilisateur = :idu AND Id_Groupe = :idg";
        $stmt = connexion::pdo()->prepare($sql);
        return $stmt->execute(['idu' => $idUtilisateur, 'idg' => $idGroupe]);
    }

    public static function insertMembre($idUtilisateur, $idGroupe, $banni) { // A revoir la table banni dans la BD
        $table = static::$objet;
        $sql = "INSERT INTO $table (Id_Utilisateur, Id_Groupe, Banni) VALUES (:idu, :idg, :banni)";
        $stmt = connexion::pdo()->prepare($sql);
        return $stmt->execute([
            'idu' => $idUtilisateur,
            'idg' => $idGroupe,
            'banni' => $banni
        ]);
    }

    public static function updateMembre($idUtilisateur, $idGroupe, $banni) {
        $table = static::$objet;
        $sql = "UPDATE $table SET Banni = :banni WHERE Id_Utilisateur = :idu AND Id_Groupe = :idg";
        $stmt = connexion::pdo()->prepare($sql);
        return $stmt->execute([
            'banni' => $banni,
            'idu'   => $idUtilisateur,
            'idg'   => $idGroupe
        ]);
    }

}

?>