<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_number'])) {
        echo json_encode(['success' => false, 'message' => 'Utilisateur non authentifié']);
        exit;
    }

    $userId = $_SESSION['user_number'];
    $groupName = isset($_POST['group_id']) ? trim($_POST['group_id']) : null; 
    $notificationId = isset($_POST['notification_id']) ? intval($_POST['notification_id']) : null;
    $senderId = isset($_POST['sender_id']) ? intval($_POST['sender_id']) : null;

    require_once('../config/connexion.php');
    $pdo = Connexion::getConnection();

    if (!is_numeric($groupName)) {
        try {
            $sql = "SELECT Id_Groupe FROM groupe WHERE Nom_Groupe = :Nom_Groupe";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Nom_Groupe', $groupName, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$result) {
                echo json_encode(['success' => false, 'message' => 'Nom de groupe invalide']);
                exit;
            }
            $groupId = $result['Id_Groupe'];
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Erreur SQL: ' . $e->getMessage()]);
            exit;
        }
    } else {
        $groupId = intval($groupName); // Nếu group_id là số, sử dụng trực tiếp
    }

    if (empty($notificationId) || empty($senderId)) {
        echo json_encode(['success' => false, 'message' => 'Paramètres notification_id ou sender_id manquants']);
        exit;
    }

    try {
        // Thêm người dùng vào nhóm
        $addMemberUrl = "https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/membre?method=POST";
        $memberData = [
            'Id_Utilisateur' => $userId,
            'Id_Groupe' => $groupId,
            'Banni' => 0
        ];

        $ch = curl_init($addMemberUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($memberData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $memberResponse = curl_exec($ch);
        $memberHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($memberHttpCode !== 200 && $memberHttpCode !== 201) {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'ajout au groupe']);
            exit;
        }

        // Cập nhật session với ID nhóm hiện tại
        $_SESSION['groupe'] = $groupId;

        // Xóa thông báo liên quan
        try {
            $sql = "DELETE FROM Notifications 
                    WHERE Id_Notification = :Id_Notification 
                      AND Id_Recepteur = :Id_Recepteur 
                      AND Id_Emetteur = :Id_Emetteur";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Id_Notification', $notificationId, PDO::PARAM_INT);
            $stmt->bindParam(':Id_Recepteur', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':Id_Emetteur', $senderId, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() === 0) {
                echo json_encode(['success' => false, 'message' => 'Aucune notification trouvée à supprimer']);
                exit;
            }
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Erreur SQL: ' . $e->getMessage()]);
            exit;
        }

        // Chuyển hướng đến trang accueil_groupe.php
        header("Location: acceuil_groupe.php");
        exit;
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Erreur: ' . $e->getMessage()]);
        exit;
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
    exit;
}
