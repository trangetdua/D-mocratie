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
	$url ="https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/groupe/id/$nom/null/$couleur/null/$_SESSION['user_number']/?method=POST";
    $curl = curl_init($url);
	curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
    $response = curl_exec($curl);
	print_r($response);
    $_SESSION['groupe'] = $response[1];
	$_SESSION['role'] = "administrateur";
    header('Location: acceuil_groupe.php');

} catch (Exception $e) {
    echo $e->getMessage();
}

?>
