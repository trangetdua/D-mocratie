<?php
require_once ('../config/connexion.php'); 

try{
$message ='';
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
	$url ="https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/utilisateur/?method=GET";
	echo $url;
    $curl = curl_init($url);
	curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
	$user = json_decode(curl_exec($curl),true);
	$message = "";
	foreach ($user as $u){
		if ($u['Mail_Utilisateur']==$username && $u['Login_Utilisateur']==$password){
				session_start();
				$_SESSION['user_id'] =$u['Mail_Utilisateur'];
				$message = "connecte";
				header('Location: acceuil.php');
				
		}
	}
	if ($message != "connecte"){
		header('Location: conne.php?identifiant=faux');
	}

   


}
} catch (Exception $e) {
    echo $e->getMessage();
}

?>
