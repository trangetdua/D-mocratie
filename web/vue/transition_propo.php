<?php
require_once("isConnected.php");

try{
	$_SESSION['proposition'] = $_GET['id'];
		
	header('Location: proposition.php');
}
catch (Exception $e) {
    echo $e->getMessage();
}

?>
