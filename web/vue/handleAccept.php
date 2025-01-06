<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_number'])) {
        echo json_encode(['success' => false, 'message' => 'Utilisateur non authentifié']);
        exit;
    }

    $userId = $_SESSION['user_number'];
    $groupId = isset($_POST['group_id']) ? trim($_POST['group_id']) : null;
    $notificationId = isset($_POST['notification_id']) ? intval($_POST['notification_id']) : null;
    $senderId = isset($_POST['sender_id']) ? intval($_POST['sender_id']) : null;

    // Debug POST data
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    if (empty($groupId) || empty($notificationId) || empty($senderId)) {
        echo json_encode(['success' => false, 'message' => 'Paramètres invalides']);
        exit;
    }

    require_once('../config/connexion.php'); 
    $pdo = Connexion::getConnection();

    try {
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

        if (!isset($_SESSION['groupe']) || !is_array($_SESSION['groupe'])) {
            $_SESSION['groupe'] = []; // Khởi tạo mảng nếu chưa tồn tại
        }
        // Mettre à jour avec nouveau groupe
        $_SESSION['groupe'][] = $groupId; // Thêm nhóm mới vào danh sách nhóm trong session

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

        header("Location: acceuil_groupe.php?group_id=$groupId");
        exit;
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Erreur: ' . $e->getMessage()]);
        exit;
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
    exit;
}
