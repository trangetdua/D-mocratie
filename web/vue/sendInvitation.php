<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? null;
    $groupId = $_POST['groupId'] ?? null;

    if (!$email || !$groupId) {
        echo "<p style='color:red;'>Erreur : Email ou groupe non spécifié.</p>";
        exit;
    }

    try {
        // Gọi API để kiểm tra người dùng
        $apiUrlCheckUser = "https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/utilisateur?method=GET&Mail_Utilisateur=$email";
        $responseCheckUser = file_get_contents($apiUrlCheckUser);
        $user = json_decode($responseCheckUser, true);

        if (!$user || empty($user['Id_Utilisateur'])) {
            echo "<p style='color:red;'>Erreur : Utilisateur n'existe pas.</p>";
            exit;
        }

        // Lấy ID người dùng từ API
        $userId = $user['Id_Utilisateur'];

        // Gọi API để thêm thông báo
        $apiUrlNotification = "https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/Notifications?method=POST";
        $notificationData = [
            'Id_Utilisateur' => $userId,
            'Regularite_Notification' => "Vous êtes invité à rejoindre le groupe ID $groupId"
        ];

        $options = [
            'http' => [
                'header'  => "Content-Type: application/json\r\n",
                'method'  => 'POST',
                'content' => json_encode($notificationData),
            ],
        ];
        $context  = stream_context_create($options);
        $responseNotification = file_get_contents($apiUrlNotification, false, $context);

        if ($responseNotification === false) {
            throw new Exception("Erreur lors de la requête à l'API Notifications.");
        }

        echo "<p style='color:green;'>L'invitation a été envoyée avec succès.</p>";
    } catch (Exception $e) {
        echo "<p style='color:red;'>Erreur : " . htmlspecialchars($e->getMessage()) . "</p>";
    }
} else {
    echo "<p style='color:red;'>Méthode non autorisée.</p>";
}
