<?php
require_once("isConnected.php");

try{
	$aSignaler = $_GET['id'];
	$page = $_GET['page'];
	$type = $_GET['type'];

	$data = (la tu fais un get) 
	$nombre = $data['Signaler']
	url de modication( je crois que cest PUT) ou tu modifie la collone signaler et tu la remplace par $nombre


		
	header('Location: '.$page.'.php ');
}
catch (Exception $e) {
    echo $e->getMessage();
}

?>
