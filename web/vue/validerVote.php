<?php
require_once("isConnected.php");

try{
	$id = $_GET['id'];
	$page = $_GET['page'];
	$type = $_GET['type'];

	$data = $curlUti = curl_init('https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/Vote?method=GET');
	curl_setopt($curlUti,CURLOPT_RETURNTRANSFER,1);
	$utis = json_decode(curl_exec($curlUti),true);
	for each($utis as $vote){
		if($vote['Id_Vote']==$id){
		$nombre = $vote['Signaler']
		}
	}
	$nombre = $nombre +1;
	$url="https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/Vote/Id_Vote/9/Signaler/$nombre/?method=PUT ";
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_exec($curl);


		
	header('Location: proposition.php');
}
catch (Exception $e) {
    echo $e->getMessage();
}

?>
