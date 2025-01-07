<?php
require_once("isConnected.php");

try{
	$id = $_GET['id'];

	$url="https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/Vote/Id_Vote/$id/valide/1/?method=PUT ";
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_exec($curl);


		
	header('Location: vote.php');
}
catch (Exception $e) {
    echo $e->getMessage();
}

?>
