<?php
require_once('modele.php');

class RoleUtilisateur extends modele {
    protected static $objet = 'role_utilisateur';
    protected static $cle = 'Id_Role';

    public static function getRoleUtilisateurById($idUtilisateur, $idRole) {
        $table = static::$objet;
        $sql = "SELECT * FROM $table WHERE Id_Utilsateur = :iu AND Id_Role = :ir";
        $stmt = connexion::pdo()->prepare($sql);
        $stmt->execute(['iu' => $idUtilisateur, 'ir' => $idRole]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        return $stmt->fetch();
    }

    public static function deleteRoleUtilisateur($idUtilisateur, $idRole) {
        $table = static::$objet;
        $sql = "DELETE FROM $table WHERE Id_Utilsateur = :iu AND Id_Role = :ir";
        $stmt = connexion::pdo()->prepare($sql);
        return $stmt->execute(['iu' => $idUtilisateur, 'ir' => $idRole]);
    }

    public static function insertRoleUtilisateur($idUtilisateur, $idRole) {
        $table = static::$objet;
        $sql = "INSERT INTO $table (Id_Utilsateur, Id_Role) VALUES (:iu, :ir)";
        $stmt = connexion::pdo()->prepare($sql);
        return $stmt->execute(['iu' => $idUtilisateur, 'ir' => $idRole]);
    }
}

?>