<?php
require_once ('../config/connexion.php'); 

try{
$message ='';
    $_POST['nom'];
    $_POST['cocouleur'];
	if(isset($theme1
    echo $message;
	$url ="https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/utilisateur/$username/?method=GET";
	echo $url;
    $curl = curl_init($url);
	curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
	$user = json_decode(curl_exec($curl),true);
    echo "$username <br>";
    if (is_null($user)){
        echo "je vais me defenestrer";
    }
    echo "ldsch";
    print_r($user);
    echo "hdsijhcds";

    if ($user["message"] == "Utilisateur non trouvé"){
        header('Location: conne.php?identifiant=faux');
    }
    
    
	elseif ($user && $password==$user[0]['Login_Utilisateur'] ) {
        session_start();
        $_SESSION['user_id'] =$user[0]['Mail_Utilisateur'];
        header('Location: acceuil.php');
        $message = "ça fonctionne";
        echo $message;
    } else {
        header('Location: conne.php?identifiant=faux');

    }



}
} catch (Exception $e) {
    echo $e->getMessage();
}

?>
