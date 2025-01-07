<?php
require_once("isConnected.php");

try{

	$id = $_GET['id'];
	$page = $_GET['page'];
	$table = $_GET['table'];
	$nom = $_GET['nom'];

	$data = $curlUti = curl_init("https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/$table?method=GET");
	curl_setopt($curlUti,CURLOPT_RETURNTRANSFER,1);
	$utis = json_decode(curl_exec($curlUti),true);
	for each($utis as $info){
		if($info[$nom]==$id){
		$nombre = $info['Signaler']
		}
	}
	$nombre = $nombre +1;
	$url="https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/$table/$nom/$id/Signaler/$nombre/?method=PUT ";
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_exec($curl);

		
	header('Location: '.$page.'.php ');
}
catch (Exception $e) {
    echo $e->getMessage();
}

?>
