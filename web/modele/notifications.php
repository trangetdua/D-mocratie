<?php
require_once('modele.php');

class Notifications extends modele {
    protected static $objet = 'notifications';
    protected static $cle = 'null';

    public static function getNotificationsById($idUtilisateur, $idNotification) {
        $table = static::$objet;
        $sql = "SELECT * FROM $table WHERE Id_Utilsateur = :iu AND Id_Notification = :in";
        $stmt = connexion::pdo()->prepare($sql);
        $stmt->execute(['iu' => $idUtilisateur, 'in' => $idNotification]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        return $stmt->fetch();
    }

    public static function deleteNotifications($idUtilisateur, $idNotification) {
        $table = static::$objet;
        $sql = "DELETE FROM $table WHERE Id_Utilsateur = :iu AND Id_Notification = :in";
        $stmt = connexion::pdo()->prepare($sql);
        return $stmt->execute(['iu' => $idUtilisateur, 'in' => $idNotification]);
    }

    public static function insertNotifications($idUtilisateur, $idNotification) {
        $table = static::$objet;
        $sql = "INSERT INTO $table (Id_Utilsateur, Id_Notification) VALUES (:iu, :in)";
        $stmt = connexion::pdo()->prepare($sql);
        return $stmt->execute(['iu' => $idUtilisateur, 'in' => $idNotification]);
    }
}

?>