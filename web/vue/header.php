<!DOCTYPE html>
<html lang = "fr">
	<head>
		<meta charset = "utf-8">
		<title>Démocratie participative </title>
		<link rel="stylesheet" href ="./css/general.css">
		<link rel="stylesheet" href = "./css/stylejs.css">
		<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
		<script src="./js/jquery-accessible-hide-show-aria.js"></script>
		<script src="./js/noti.js"></script>

		
	</head>	
	<body>

    <?php
    require_once('loadNoti.php'); 
    ?>

	<header>
	<a href="acceuil.php">
		<image src="./images/home.png" alt="lien vers la page d'acceuil" >
	</a>

	<div class="header-right">
        
        <div class="notification-container">
            
            <img src="./images/noti.png" alt="Notifications" id="notification-icon" class="notification-icon">
            
            <div class="notification-dropdown" id="notification-dropdown">
            <div class="header">
            <span>Notifications</span>
            <button class="mark-all" onclick="markAllAsRead()">Mark all as read</button>
        </div>
        <ul class="notification-list">
    <?php if (!empty($notifications)): ?>
        <?php foreach ($notifications as $notification): ?>
            <?php 
            $groupId = isset($notification['title']) ? htmlspecialchars($notification['title']) : null;
            $notificationId = isset($notification['notification_id']) ? htmlspecialchars($notification['notification_id']) : null;
            ?>
            <li class="notification-item">
                <p><strong><?= htmlspecialchars($notification['title']) ?></strong></p>
                <p><?= htmlspecialchars($notification['message']) ?></p>

                <?php if ($groupId && $notificationId): ?>
                    <form action="handleAccept.php" method="POST" style="display:inline;">
                        <input type="hidden" name="group_id" value="<?= $groupId ?>">
                        <input type="hidden" name="notification_id" value="<?= $notificationId ?>">
                        <input type="hidden" name="sender_id" value="<?= htmlspecialchars($notification['sender_id']) ?>">
                        <button type="submit" class="accept-button">Accepter</button>
                    </form>
                    <button class="decline-btn" data-notification-id="<?= $notificationId ?>">Refuser</button>
                <?php else: ?>
                    <p>Erreur : Informations manquantes.</p>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    <?php else: ?>
        <li class="notification-item">
            <p>No notifications available</p>
        </li>
    <?php endif; ?>
</ul>

    </div>
	
        </div>
	
    <a href="profil.php">
         <img src="./images/pdpUtilisateur.png" alt="photo de profil utilisateur, lien vers la page profil" id="p">
    </a>

	</header>
	<main>

