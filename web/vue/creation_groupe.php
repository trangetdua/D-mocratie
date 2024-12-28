<?php
require_once ('../config/connexion.php'); 

try{

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nom = $_POST['nom'];
    $couleur = $_POST['couleur'];
	$theme1 = $_POST['Theme1'] ?? null;
	$theme1 = $_POST['Theme2'] ?? null;

	/*if(isset($_POST['Theme1'])){
		$theme1 = $_POST['Theme1'];
	}
	else{
		$theme1 = null;
	}
	if(isset($_POST['Theme2'])){
		$theme1 = $_POST['Theme2'];
	}
	else{
		$theme2 = null;
	}
	*/
	
	$url ="https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/groupe/id/$nom/null/$couleur/null/$_SESSION[?method=POST";
	echo $url;
    $curl = curl_init($url);
	curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
	curl_exec($curl);
    $_SESSION['groupe']
	$_SESSION['role'] = "administrateur";
    header('Location: acceuil.php');

} catch (Exception $e) {
    echo $e->getMessage();
}

?>
