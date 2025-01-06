<?php
session_start();
require_once('../config/connexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['groupe'])) {
        echo json_encode(['success' => false, 'message' => 'Aucun groupe sélectionné']);
        exit;
    }

    $currentUserId = $_SESSION['user_number']; // emetteur
    $groupeId = $_SESSION['groupe'];
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';

    if (empty($email)) {
        echo json_encode(['success' => false, 'message' => 'Veuillez entrer une adresse e-mail.']);
        exit;
    }

    try {
        $groupeApiUrl = "https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/groupe?method=GET";
        $groupeResponse = file_get_contents($groupeApiUrl);
        $groupes = json_decode($groupeResponse, true);

        $nomGroupeBrut = null;

        foreach ($groupes as $groupe) {
            if ($groupe['Id_Groupe'] == $groupeId) {
                $nomGroupeBrut = $groupe['Nom_Groupe'];
                break;
            }
        }

        if (!$nomGroupeBrut) {
            echo json_encode(['success' => false, 'message' => 'Nom du groupe introuvable']);
            exit;
        }

        $utilisateurApiUrl = "https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/utilisateur?method=GET";
        $utilisateurResponse = file_get_contents($utilisateurApiUrl);
        $users = json_decode($utilisateurResponse, true);
        $invitee = null;

        foreach ($users as $user) {
            if ($user['Mail_Utilisateur'] === $email) {
                $invitee = $user;
                break;
            }
        }

        if (!$invitee) {
            echo json_encode(['success' => false, 'message' => 'Utilisateur non trouvé.']);
            exit;
        }

        $inviteeId = $invitee['Id_Utilisateur']; //Recepteur

        $regularite = urlencode("Invitation au groupe $nomGroupeBrut");
        $typeNotificationGetUrl = "https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/Type_Notification/Regularite_Notification/$regularite/Id_Groupe/$groupeId?method=GET";

        $typeNotificationResponse = file_get_contents($typeNotificationGetUrl);
        $typeNotifications = json_decode($typeNotificationResponse, true);
        $typeNotificationId = null;

        if (!empty($typeNotifications)) {
            $typeNotificationId = $typeNotifications[0]['Id_Notification'];
        } else {
            $typeNotificationPostUrl = "https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/Type_Notification?method=POST";
            $typeNotificationData = [
                'Regularite_Notification' => "Invitation au groupe $nomGroupeBrut",
                'Id_Groupe' => $groupeId
            ];

            $ch = curl_init($typeNotificationPostUrl);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($typeNotificationData));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $typeNotificationResponse = curl_exec($ch);
            $typeNotificationHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($typeNotificationHttpCode !== 200 && $typeNotificationHttpCode !== 201) {
                echo json_encode(['success' => false, 'message' => 'Erreur lors de la création du type de notification']);
                exit;
            }

            $typeNotificationResult = json_decode($typeNotificationResponse, true);
            if (isset($typeNotificationResult['id'])) {
                $typeNotificationId = $typeNotificationResult['id'];
            } else {
                echo json_encode(['success' => false, 'message' => 'Erreur lors de la récupération de l\'ID du type de notification']);
                exit;
            }
        }

        // Kiểm tra xem đã có thông báo mời chưa thông qua API
        $checkNotificationUrl = "https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/Notifications?method=GET";
        $checkNotificationResponse = file_get_contents($checkNotificationUrl);
        $allNotifications = json_decode($checkNotificationResponse, true);
        $invitationAlreadySent = false;
    
        foreach ($allNotifications as $notification) {
            if (
                isset($notification['Id_Emetteur'], $notification['Id_Notification'], $notification['Id_Recepteur'])
                && $notification['Id_Emetteur'] == $currentUserId
                && $notification['Id_Recepteur'] == $inviteeId
                && $notification['Id_Notification'] == $typeNotificationId
            ) {
                $invitationAlreadySent = true;
                break;
            }
        }
    
        if ($invitationAlreadySent) {
            echo json_encode(['success' => false, 'message' => 'Une invitation a déjà été envoyée à cette adresse e-mail.']);
            exit;
        }

        $notificationsPostUrl = "https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/Notifications?method=POST";
            $notificationData = [
                'Id_Emetteur'    => $currentUserId,
                'Id_Notification' => $typeNotificationId,
                'Id_Recepteur'   => $inviteeId
            ];
    
            $ch = curl_init($notificationsPostUrl);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($notificationData));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $notificationResponse = curl_exec($ch);
        $notificationHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($notificationHttpCode !== 200 && $notificationHttpCode !== 201) {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'envoi de l\'invitation']);
            exit;
        }

        echo json_encode(['success' => true, 'message' => 'Invitation envoyée avec succès']);
        exit;
        
        
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Erreur: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
}
?>
