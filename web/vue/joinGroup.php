<?php
require_once('../config/connexion.php');
session_start();

$pdo = Connexion::getConnection();

$groupId = $_GET['group'] ?? null;
$userId = $_GET['user'] ?? null;

$action = $_GET['action'] ?? null; // Action: accept hoặc refuse

if (!$groupId || !$userId || !$action) {
    echo "Paramètres invalides.";
    exit;
}

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
    header("Location: login.php?redirect=joinGroup.php&group=$groupId&user=$userId&action=$action");
    exit;
}

// Kiểm tra xem người dùng có trùng khớp với lời mời
if ($_SESSION['user_id'] != $userId) {
    echo "Erreur: Vous n'êtes pas l'utilisateur invité.";
    exit;
}

if ($action === 'accept') {
    // Người dùng đồng ý tham gia nhóm
    $stmt = $pdo->prepare("UPDATE membre SET Banni = 0 WHERE Id_Utilisateur = :userId AND Id_Groupe = :groupId");
    $stmt->execute([':userId' => $userId, ':groupId' => $groupId]);

    // Chuyển hướng đến trang `accueil_groupe.php`
    header("Location: accueil_groupe.php?group=$groupId");
    exit;
} elseif ($action === 'refuse') {
    // Người dùng từ chối tham gia nhóm
    // Xóa bản ghi trong bảng `membre` nếu cần
    $stmt = $pdo->prepare("DELETE FROM membre WHERE Id_Utilisateur = :userId AND Id_Groupe = :groupId");
    $stmt->execute([':userId' => $userId, ':groupId' => $groupId]);

    header("Location: accueil.php");
    exit;
} else {
    echo "Action inconnue.";
    exit;
}


// Cập nhật trạng thái của người dùng trong nhóm
$stmt = $pdo->prepare("UPDATE membre SET Banni = 0 WHERE Id_Utilisateur = :userId AND Id_Groupe = :groupId");
$stmt->execute([':userId' => $userId, ':groupId' => $groupId]);

// Hiển thị thông báo thành công
echo "Vous avez rejoint le groupe avec succès !";
?>
