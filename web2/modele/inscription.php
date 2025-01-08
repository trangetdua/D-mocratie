<?php
session_start();
require_once ('../config/connexion.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

$message = ""; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = isset($_POST['Nom_Utilisateur']) ? trim($_POST['Nom_Utilisateur']) : null;
    $prenom = isset($_POST['Prenom_Utilisateur']) ? trim($_POST['Prenom_Utilisateur']) : null;
    $adresse = isset($_POST['Adr_Utilisateur']) ? trim($_POST['Adr_Utilisateur']) : null;
    $codePostal = isset($_POST['Cp_Utilisateur']) ? intval($_POST['Cp_Utilisateur']) : null;
    $email = isset($_POST['Mail_Utilisateur']) ? trim($_POST['Mail_Utilisateur']) : null;
    $login = isset($_POST['Login_Utilisateur']) ? trim($_POST['Login_Utilisateur']) : null;

    
    if (empty($nom) || empty($prenom) || empty($adresse) || empty($codePostal) || empty($email) || empty($login)) {
        throw new Exception("Données invalides ou incomplètes.");
    }


    try {
        // Vérifier si email déjà existe
        $checkUrl = "https://projets.iut-orsay.fr/saes3-aviau/TestProket/web2/controller/api.php/utilisateur/?method=GET";
        $curl = curl_init($checkUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($curl);

        if ($response === false) {
            throw new Exception("Erreur lors de la connexion à l'API: " . curl_error($curl));
        }

        /*echo "<pre>Response from API: " . htmlspecialchars($response) . "</pre>";
        exit;*/

        $users = json_decode($response, true);

        if (!is_array($users)) {
            throw new Exception("La réponse API n'est pas un tableau valide.");
        }

        $validUsers = array_filter($users, function ($user) {
            return isset($user['Mail_Utilisateur'], $user['Login_Utilisateur']) &&
                   !is_null($user['Mail_Utilisateur']) && !is_null($user['Login_Utilisateur']);
        });

        foreach ($validUsers as $user) {
            if ($user['Mail_Utilisateur'] === $email || $user['Login_Utilisateur'] === $login) {
                header('Location: ../vue/register.php?error=email_exists');
                exit;
            }
        }

        // Envoyer les données
        $registerUrl = "https://projets.iut-orsay.fr/saes3-aviau/TestProket/web2/controller/api.php/utilisateur/?method=POST";
        $data = [
            'Nom_Utilisateur' => $nom,
            'Prenom_Utilisateur' => $prenom,
            'Adr_Utilisateur' => $adresse,
            'Cp_Utilisateur' => $codePostal,
            'Mail_Utilisateur' => $email,
            'Login_Utilisateur' => $login,
        ];

        $curl = curl_init($registerUrl);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($curl);

        if ($response === false) {
            throw new Exception("Erreur lors de l'envoi des données: " . curl_error($curl));
        }

        $result = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Erreur de décode JSON: " . json_last_error_msg());
        }

        if (isset($result['id'])) {
            
            $_SESSION['fullname'] = $nom . ' ' . $prenom;
            
            header('Location: ../vue/connection.php');
            exit;

        } else {
            if (is_array($result) && isset($result['message'])) {
                throw new Exception("Erreur lors de l'enregistrement: " . $result['message']);
            } else {
                throw new Exception("Erreur lors de l'enregistrement: Réponse invalide de l'API.");
            }
        }

    } catch (Exception $e) {
        echo "<p style='color:red;'>Erreur: " . $e->getMessage() . "</p>";
    }
}
?>
