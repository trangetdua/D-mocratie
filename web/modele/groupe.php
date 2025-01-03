<?php
    require_once('modele.php');

class Utilisateur extends modele{

    protected static $objet ="groupe";
    protected static $cle ="Id_Groupe";

    protected string $Id_Groupe;
    protected string $Nom_Groupe;
    protected string $Image_Groupe;
    protected string $Couleur_Groupe;
    protected string $Limite_Budget_Global;
    protected string $Id_Utilisateur;
    
    
}
?>