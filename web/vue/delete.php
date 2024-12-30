<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

$table = $_GET['table'] ?? 'utilisateurs'; 
$key = $_GET['key'] ?? 'Id_Utilisateur';  
$value = $_SESSION['user_number'] ?? ($_GET['value'] ?? null); 


if (empty($table) || empty($key) || empty($value)) {
    echo "<p style='color:red;'>Erreur: Paramètres manquants</p>";
    error_log("Paramètres manquants: Table = $table, Key = $key, Value = $value");
    exit;
}

try {
    $url = "https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/{$table}?method=DELETE&key={$key}&value={$value}";

    if (empty($table) || empty($key) || empty($value)) {
        echo "<p style='color:red;'>Erreur: Paramètres manquants</p>";
        error_log("Paramètres manquants: Table = $table, Key = $key, Value = $value");
        exit;
    }

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($curl);

    if ($response === false) {
        $curlError = curl_error($curl);
        error_log("Erreur cURL: $curlError");
        throw new Exception("Erreur API (cURL): $curlError");
    }

    $httpStatusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    error_log("HTTP Status Code: $httpStatusCode");

    if ($httpStatusCode < 200 || $httpStatusCode >= 300) {
        throw new Exception("Erreur API - HTTP Status Code: $httpStatusCode");
    }

    $result = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Erreur de décodage JSON: " . json_last_error_msg());
    }

    if (isset($result['message']) && strpos($result['message'], 'supprimé') !== false) {
        session_destroy();
        header("Location: connection.php?message=deleted");
        exit;
    } else {
        throw new Exception($result['message'] ?? 'Erreur inconnue lors de la suppression');
    }
} catch (Exception $e) {
    echo "<p style='color:red;'>Erreur: " . htmlspecialchars($e->getMessage()) . "</p>";
    error_log("Exception: " . $e->getMessage());
}
?>
