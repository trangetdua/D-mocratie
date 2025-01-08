<?php
require_once("isConnected.php");

try{
		$_SESSION['groupe'] = $_GET['id'];
		$curl = curl_init('https://projets.iut-orsay.fr/saes3-aviau/TestProket/web2/controller/api.php/role_groupe/Id_Role/role/?method=GET');
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
		$data = json_decode(curl_exec($curl),true);		
		$_SESSION['role'] = "membre";
		foreach ($data as $value){
			if($value['Id_Utilisateur']==$_SESSION['user_number'] && $value['Id_Groupe']==$_SESSION['groupe']){
				$_SESSION['role'] =$value['Nom_Role'];
				break;
			}
		}
		header('Location: ../vue/acceuil_groupe.php');
}
catch (Exception $e) {
    echo $e->getMessage();
}

?>
