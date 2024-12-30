<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

$table = $_GET['table'] ?? 'utilisateur'; // Bảng mặc định
$key = $_GET['key'] ?? 'Id_Utilisateur';  // Cột mặc định
$value = $_SESSION['user_number'] ?? ($_GET['value'] ?? null); // Giá trị từ session hoặc URL (nếu có)

if (empty($table) || empty($key) || empty($value)) {
    echo "<p style='color:red;'>Erreur: Paramètres manquants</p>";
    exit;
}

try {
    
    $deleteUrl = "https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/{$table}?method=DELETE&key={$key}&value={$value}";

    $curlDelete = curl_init($deleteUrl);
    curl_setopt($curlDelete, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($curlDelete, CURLOPT_RETURNTRANSFER, true);

    $responseDelete = curl_exec($curlDelete);

    if ($responseDelete === false) {
        throw new Exception("Erreur API DELETE: " . curl_error($curlDelete));
    }

    $httpStatusCode = curl_getinfo($curlDelete, CURLINFO_HTTP_CODE);
    echo "<pre>Response from API: " . htmlspecialchars($responseDelete) . "</pre>"; // Debug phản hồi từ API


    if ($httpStatusCode < 200 || $httpStatusCode >= 300) {
        echo "<pre>API Response: " . htmlspecialchars(json_encode($resultDelete)) . "</pre>";
        throw new Exception("Erreur API DELETE - HTTP Status Code: $httpStatusCode");
    }

    $resultDelete = json_decode($responseDelete, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo "<pre>Response from API: " . htmlspecialchars($responseDelete) . "</pre>"; //debug
        throw new Exception("Erreur de décodage JSON (DELETE): " . json_last_error_msg());
    }

    if (isset($resultDelete['message']) && strpos($resultDelete['message'], 'supprimé') !== false) {
        session_destroy();
        header("Location: connection.php?message=deleted");
        exit;
    } else {
        echo "<pre>API Response: " . htmlspecialchars(json_encode($resultDelete)) . "</pre>";
        throw new Exception($resultDelete['message'] ?? 'Erreur inconnue lors de la suppression');
    }
} catch (Exception $e) {
    echo "<p style='color:red;'>Erreur: " . htmlspecialchars($e->getMessage()) . "</p>";
}
