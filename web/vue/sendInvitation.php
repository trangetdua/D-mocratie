<?php
require_once('../config/connexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';

    if (empty($email)) {
        header("Location: invitation.php?error=empty_email");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: invitation.php?error=invalid_email");
        exit;
    }

    // Lấy thông tin người mời từ session
    if (!isset($_SESSION['user_number'])) {
        header("Location: invitation.php?error=not_logged_in_or_no_group");
        exit;
    }

    $inviter_id = $_SESSION['user_number'];

    try {
        $apiUrl = "https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/utilisateur?method=GET";

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json"
            ]
        ]);

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($httpCode !== 200) {
            throw new Exception("Erreur lors de la récupération des utilisateurs.");
        }

        $allUsers = json_decode($response, true);

        // Tìm người dùng theo email
        $invitee = null;
        foreach ($allUsers as $user) {
            if ($user['Mail_Utilisateur'] === $email) {
                $invitee = $user;
                break;
            }
        }

        if (!$invitee) {
            header("Location: invitation.php?error=user_not_found");
            exit;
        }

        $invitee_id = $invitee['Id_Utilsateur'];

        $groupApiUrl = "https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/membre/Id_Utilisateur/$inviter_id?method=GET";

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $groupApiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json"
            ]
        ]);

        $groupResponse = curl_exec($curl);
        $groupHttpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($groupHttpCode !== 200) {
            throw new Exception("Erreur lors de la récupération des groupes de l'utilisateur.");
        }

        $groups = json_decode($groupResponse, true);

        if (empty($groups)) {
            // Người mời không thuộc nhóm nào
            header("Location: invitation.php?error=not_logged_in_or_no_group");
            exit;
        }

        // Giả sử người mời chỉ thuộc một nhóm
        $group_id = $groups[0]['Id_Groupe'];

        // Sử dụng API để kiểm tra xem đã có thông báo mời chưa
        $checkApiUrl = "https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/Notifications?method=GET";

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $checkApiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json"
            ]
        ]);
 
        $notificationsResponse = curl_exec($curl);
        $notificationsHttpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
 
        if ($notificationsHttpCode !== 200) {
            throw new Exception("Erreur lors de la récupération des notifications.");
        }
        $allNotifications = json_decode($notificationsResponse, true);

        // Tìm xem đã có thông báo mời chưa
        $invitationAlreadySent = false;
        foreach ($allNotifications as $notification) {
            if ($notification['Id_Utilisateur'] == $invitee_id && $notification['Regularite_Notification'] == 'Invitation au groupe' && $notification['Id_Groupe'] == $group_id) {
                $invitationAlreadySent = true;
                break;
            }
        }
        if ($invitationAlreadySent) {
            header("Location: invitation.php?error=invitation_already_sent");
            exit;
        }

        // Sử dụng API để lấy Id_Notification cho 'Invitation au groupe' và nhóm tương ứng
        $typeNotificationApiUrl = "https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/Type_Notification/Regularite_Notification/Invitation au groupe/Id_Groupe/$group_id?method=GET";
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $typeNotificationApiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json"
            ]
        ]);

        $typeNotificationResponse = curl_exec($curl);
        $typeNotificationHttpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($typeNotificationHttpCode !== 200) {
            throw new Exception("Erreur lors de la récupération du type de notification.");
        }

        $typeNotifications = json_decode($typeNotificationResponse, true);

        if (empty($typeNotifications)) {
            // Nếu loại thông báo chưa tồn tại, thêm mới bằng API
            $addTypeNotificationApiUrl = "https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/Type_Notification";
            $postData = [
                'Regularite_Notification' => 'Invitation au groupe',
                'Id_Groupe' => $group_id
            ];

            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $addTypeNotificationApiUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_HTTPHEADER => [
                    "Content-Type: application/json"
                ],
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($postData)
            ]);

            $addTypeNotificationResponse = curl_exec($curl);
            $addTypeNotificationHttpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);

            if ($addTypeNotificationHttpCode !== 200 && $addTypeNotificationHttpCode !== 201) {
                throw new Exception("Erreur lors de l'ajout du type de notification.");
            }

            $addedTypeNotification = json_decode($addTypeNotificationResponse, true);
            $type_notification_id = $addedTypeNotification['id'] ?? null;

            if (!$type_notification_id) {
                throw new Exception("Impossible de récupérer l'ID du type de notification ajouté.");
            }
        } else {
            // Lấy Id_Notification từ kết quả API
            $type_notification_id = $typeNotifications[0]['Id_Notification'];
        }

        // Sử dụng API để thêm thông báo mới
        $addNotificationApiUrl = "https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/Notifications";
            $postData = [
                'Id_Utilisateur' => $invitee_id,
                'Id_Notification' => $type_notification_id
            ];
    
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $addNotificationApiUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_HTTPHEADER => [
                    "Content-Type: application/json"
                ],
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($postData)
            ]);

            $addNotificationResponse = curl_exec($curl);
        $addNotificationHttpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($addNotificationHttpCode !== 200 && $addNotificationHttpCode !== 201) {
            throw new Exception("Erreur lors de l'ajout de la notification.");
        }

        // Chuyển hướng trở lại form với thông báo thành công
        header("Location: invitation.php?success=invitation_sent");
        exit;
        
    } catch (Exception $e) {
        // Nếu có lỗi, ghi log và chuyển hướng với thông báo lỗi
        error_log("Erreur lors de l'envoi de l'invitation: " . $e->getMessage());
        header("Location: invitation.php?error=database_error");
        exit;
    }

} else {
    // Nếu không phải là yêu cầu POST, chuyển hướng trở lại form
    header("Location: invitation.php");
    exit;
}
?>
