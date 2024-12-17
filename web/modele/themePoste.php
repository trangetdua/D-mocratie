<?php
require_once('modele.php');

class ThemePoste extends modele {
    protected static $objet = 'theme_poste';
    protected static $cle = null;

    public static function getThemePosteById($idTheme, $idProposition) {
        $table = static::$objet;
        $sql = "SELECT * FROM $table WHERE Id_Theme = :it AND id_proposition = :ip";
        $stmt = connexion::pdo()->prepare($sql);
        $stmt->execute(['it' => $idTheme, 'ip' => $idProposition]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        return $stmt->fetch();
    }

    public static function deleteThemePoste($idTheme, $idProposition) {
        $table = static::$objet;
        $sql = "DELETE FROM $table WHERE Id_Theme = :it AND id_proposition = :ip";
        $stmt = connexion::pdo()->prepare($sql);
        return $stmt->execute(['it' => $idTheme, 'ip' => $idProposition]);
    }

    public static function insertThemePoste($idTheme, $idProposition) {
        $table = static::$objet;
        $sql = "INSERT INTO $table (Id_Theme, id_proposition) VALUES (:it, :ip)";
        $stmt = connexion::pdo()->prepare($sql);
        return $stmt->execute(['it' => $idTheme, 'ip' => $idProposition]);
    }
}

?>