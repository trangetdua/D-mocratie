<?php
session_start();
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

        $loginSuccess = false; //Vérifier l'existence du compte

        foreach ($users as $user) {
            
            if (strcasecmp(trim($user['Mail_Utilisateur']), trim($email)) === 0 && 
            strcasecmp(trim($user['Login_Utilisateur']), trim($password)) === 0) {
                
                $_SESSION['user_id'] = $user['Mail_Utilisateur'];
				$_SESSION['user_number'] = $user['Id_Utilisateur'];

                $_SESSION['fullname'] = $user['Nom_Utilisateur'] . ' ' . $user['Prenom_Utilisateur'];
                
                header('Location: acceuil.php');
                exit;
            }
        }

        header('Location: connection.php?error=invalid');
        exit;

    } else {
        header('Location: connection.php?error=missing');
        exit;
    }
	
}
} catch (Exception $e) {
    echo "<p style='color:red;'>Erreur: " . $e->getMessage() . "</p>";
}

?>
