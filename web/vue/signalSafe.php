<?php
require_once("isConnected.php");

try{
	$id = $_GET['id'];
	$table = $_GET['table'];
	$key=$_GET['key'];
	$url = "https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/$table/$key/$id/Signaler/0/?method=PUT";
	echo $url;
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_exec($curl);

	//header('Location: parametres.php');
}
catch (Exception $e) {
    echo $e->getMessage();
}

?>
