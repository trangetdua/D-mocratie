<?php
require_once ('../config/connexion.php'); 

try{
$message ='';
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $message = "avant url";
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
    print_r($user);

    
	if ($user && $password==$user[0]['Login_Utilisateur'] ) {
        session_start();
        $_SESSION['user_id'] =$user[0]['Mail_Utilisateur'];
        //header('Location: dashboard.php');
        $message = "ça fonctionne";
        echo $message;
    } else {
        echo $user[0]['Login_Utilisateur'];
        $message = 'Mauvais identifiants';
        echo $message;
    }



}
} catch (Exception $e) {
    echo $e->getMessage();
}

?>
