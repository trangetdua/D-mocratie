<?php
    require_once('modele.php');

class Utilisateur extends modele{
    protected static $objet ="utilisateur";
    protected static $cle ="Id_Utilisateur";

    protected string $Id_Utilisateur;
    protected string $Nom_Utilisateur;
    protected string $Prenom_Utilisateur;
    protected string $Adr_Utilisateur;
    protected string $Cp_Utilisateur;
    protected string $Mail_Utilisateur;
    protected string $Login_Utilisateur;
    protected string $Pdp_Utilisateur;
    
    public function __construct($donnees = NULL) {
        parent::__construct($donnees);
    }
    
    public static function getUserByEmail($email) {
        $pdo = connexion::pdo();
        $sql = "SELECT * FROM utilisateurs WHERE Mail_Utilisateur = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
        return $stmt->fetch();
    }
}
?>