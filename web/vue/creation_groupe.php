<?php
require_once("isConnected.php");

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
	
	$createur = intval($_SESSION['user_number']);
	$url ="https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/groupe/id/$nom/null/$couleur/null/$createur/?method=POST";
	
    $curl = curl_init($url);
	curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
    $response = json_decode(curl_exec($curl),true);
	if ($response ===null){
		 echo curl_error($curl);
	}

	echo($response[0]['LAST_INSERT_ID()']);
	//on rajoute le groupe dans groupe, le role de l'utilisateur dans role_groupe et le membre a la liste des mmebres et les themes 


    $_SESSION['groupe'] = $response[0]['LAST_INSERT_ID()'];
	/*$url ="https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/groupe/$_SESSION['user_number']/$_SESSION['groupe']/0/?method=POST";
    $curl = curl_init($url);
	curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
    curl_exec($curl);
	*/

	//$_SESSION['role'] = "administrateur";
   // header('Location: acceuil_groupe.php');
}
} catch (Exception $e) {
    echo $e->getMessage();
}

?>
