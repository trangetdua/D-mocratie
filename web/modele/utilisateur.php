<?php
    require_once('modele.php');

class Utilisateur extends modele{
    protected static $objet ="utilisateur";
    protected static $cle ="Id_Utilisateur";

    protected string $id_Utilisateur;
    protected string $nom_Utilisateur;
    protected string $prenom_Utilisateur;
    protected string $adr_Utilisateur;
    protected string $cp_Utilisateur;
    protected string $mail_Utilisateur;
    protected string $login_Utilisateur;
    protected string $pdp_Utilisateur;
    
    public function __construct($donnees = NULL) {
        parent::__construct($donnees);
    }
    
}
?>