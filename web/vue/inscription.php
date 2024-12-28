<?php
require_once ('../config/connexion.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['Nom_Utilisateur']);
    $prenom = trim($_POST['Prenom_Utilisateur']);
    $adresse = trim($_POST['Adr_Utilisateur']);
    $codePostal = intval($_POST['Cp_Utilisateur']);
    $email = trim($_POST['Mail_Utilisateur']);
    $login = trim($_POST['Login_Utilisateur']);

    try {
        // Vérifier si email déjà existe
        $checkUrl = "https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/utilisateur/?method=GET";
        $curl = curl_init($checkUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($curl);

        if ($response === false) {
            throw new Exception("Erreur lors de la connexion à l'API: " . curl_error($curl));
        }

        echo "<pre>Response from API: " . htmlspecialchars($response) . "</pre>";
        exit;

        $users = json_decode($response, true);

        foreach ($users as $user) {
            if ($user['Mail_Utilisateur'] === $email || $user['Login_Utilisateur'] === $login) {
                header('Location: register.php?error=email_exists');
                exit;
            }
        }

        // Envoyer les données
        $registerUrl = "https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/utilisateur/?method=POST";
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
            header('Location: connection.php');
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
