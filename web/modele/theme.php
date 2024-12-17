<?php
    require_once('modele.php');

class Theme extends modele{
    protected static $objet ="theme";
    protected static $cle ="Id_Theme";

    protected string $Id_Theme;
    protected string $Nom_Theme;
    protected string $Description_Theme;
    protected string $Limite_Budget_Thematique;
    protected string $Id_Groupe;
    
}
?>