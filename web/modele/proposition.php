<?php
class Proposition extends modele{
    protected static $objet ="proposition";
    protected static $cle ="Id_Proposition";

    protected string $Id_Proposition;
    protected string $Titre_Proposition;
    protected string $Description_Proposition;
    protected string $Duree_Discussion_Proposition;
    protected string $evaluation_budgetaire;
    protected string $Id_Utilisateur;
    protected string $Id_Groupe;
    
    
}
?>