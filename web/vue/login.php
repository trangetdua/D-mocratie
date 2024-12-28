<?php
require_once ('../config/connexion.php'); 

error_reporting(E_ALL);
ini_set('display_errors', 1);

try{
$message ='';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;

    if ($email && $password) {
        $url ="https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/utilisateur/?method=GET";
        $curl = curl_init($url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
        $response = curl_exec($curl);

        if ($response == false) {
            throw new Exception("Erreur API: " . curl_error($curl));
        }

        $users = json_decode($response,true);

        if ($users === null) {
            throw new Exception("Réponse API invalide: $response");
        }

        foreach ($users as $user) {
            error_log("Dữ liệu API: " . print_r($user, true));
            if (strcasecmp(trim($user['Mail_Utilisateur']), trim($email)) === 0 && 
    strcasecmp(trim($user['Pdp_Utilisateur']), trim($password)) === 0) {
                session_start();
                $_SESSION['user_id'] = $user['Mail_Utilisateur'];
                header('Location: acceuil.php');
                exit;
            }
        }


        error_log("Login failed for email: $email");

    } else {
        throw new Exception("Email ou mot de passe manquant.");
    }
	
}
} catch (Exception $e) {
    echo "<p style='color:red;'>Erreur: " . $e->getMessage() . "</p>";
}

?>
