<?php
require_once("isConnected.php");

try{
	$id = $_GET['id'];
	$table = $_GET['table'];
	$key=$_GET['key'];
	$deleteUrl = "https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/$table?method=DELETE&key=$key&value=$id";

    $curlDelete = curl_init($deleteUrl);
    curl_setopt($curlDelete, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($curlDelete, CURLOPT_RETURNTRANSFER, true);
    curl_exec($curlDelete);

	header('Location: parametres.php');
}
catch (Exception $e) {
    echo $e->getMessage();
}

?>
