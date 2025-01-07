<?php
require_once("isConnected.php");

try{
	$_SESSION['vote'] = $_GET['id'];
		
	header('Location: vote.php');
}
catch (Exception $e) {
    echo $e->getMessage();
}

?>
