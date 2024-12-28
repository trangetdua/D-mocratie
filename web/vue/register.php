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
    $password = trim($_POST['Pdp_Utilisateur']);

    try {
        // Kiểm tra email hoặc login đã tồn tại thông qua API
        $checkUrl = "https://example.com/api.php/utilisateur/?method=GET";
        $curl = curl_init($checkUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($curl);

        if ($response === false) {
            throw new Exception("Erreur lors de la connexion à l'API: " . curl_error($curl));
        }

        $users = json_decode($response, true);

        foreach ($users as $user) {
            if ($user['Mail_Utilisateur'] === $email || $user['Login_Utilisateur'] === $login) {
                // Email hoặc login đã tồn tại
                header('Location: register.php?error=email_exists');
                exit;
            }
        }

        // Gửi dữ liệu qua API POST
        $registerUrl = "https://example.com/api.php/utilisateur/?method=POST";
        $data = [
            'Nom_Utilisateur' => $nom,
            'Prenom_Utilisateur' => $prenom,
            'Adr_Utilisateur' => $adresse,
            'Cp_Utilisateur' => $codePostal,
            'Mail_Utilisateur' => $email,
            'Login_Utilisateur' => $login,
            'Pdp_Utilisateur' => $password
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

        if (isset($result['id'])) {
            // Đăng ký thành công
            header('Location: connection.php');
            exit;
        } else {
            throw new Exception("Erreur lors de l'enregistrement: " . $result['message']);
        }

    } catch (Exception $e) {
        echo "<p style='color:red;'>Erreur: " . $e->getMessage() . "</p>";
    }
}
?>
