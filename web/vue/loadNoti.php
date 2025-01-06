<?php
session_start();

if (!isset($_SESSION['user_number'])) {
    header('Location: connection.php');
    exit;
}

$userId = $_SESSION['user_number']; //Emetteur

$curl = curl_init();
$apiUrl = "https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/Notifications/Id_Notification/Type_Notification/Id_Groupe/groupe/Id_Groupe/?method=GET";

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

if ($httpCode === 200) {
    $allNotifications = json_decode($response, true);

    $notifications = [];
    foreach ($allNotifications as $notification) {
        if (isset($notification['Id_Recepteur']) && $notification['Id_Recepteur'] == $userId) {
            $notifications[] = [
                'notification_id' => $notification['Id_Notification'], 
                'title' => $notification['Nom_Groupe'],                
                'message' => $notification['Regularite_Notification'], 
            ];
        }
    }

} else {
    echo "Erreur: Impossible de récupérer les notifications.";
}
?>

