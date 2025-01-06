<?php
require_once("isConnected.php");

try{
	$aSignaler = $_GET['id'];
	$page = $_GET['page'];
		
	header('Location: '.$page.'.php ');
}
catch (Exception $e) {
    echo $e->getMessage();
}

?>
