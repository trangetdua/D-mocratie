<?php
require_once('modele.php');

class Choisi extends modele {
    protected static $objet = 'choisi';
    protected static $cle = null;

    public static function getChoisiById($idUtilisateur, $idChoix) {
        $table = static::$objet;
        $sql = "SELECT * FROM $table WHERE Id_Utilsateur = :iu AND Id_Choix = :ic";
        $stmt = connexion::pdo()->prepare($sql);
        $stmt->execute(['iu' => $idUtilisateur, 'ic' => $idChoix]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        return $stmt->fetch();
    }

    public static function deleteChoisi($idUtilisateur, $idChoix) {
        $table = static::$objet;
        $sql = "DELETE FROM $table WHERE Id_Utilsateur = :iu AND Id_Choix = :ic";
        $stmt = connexion::pdo()->prepare($sql);
        return $stmt->execute(['iu' => $idUtilisateur, 'ic' => $idChoix]);
    }

    public static function insertChoisi($idUtilisateur, $idChoix) {
        $table = static::$objet;
        $sql = "INSERT INTO $table (Id_Utilsateur, Id_Choix) VALUES (:iu, :ic)";
        $stmt = connexion::pdo()->prepare($sql);
        return $stmt->execute(['iu' => $idUtilisateur, 'ic' => $idChoix]);
    }
}

?>