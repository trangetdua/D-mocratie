<?php
require_once("header.html");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inviter un membre</title>
    <link rel="stylesheet" href="./css/styleI.css">
</head>
<body>
<main class="container">
        <div class="form-wrapper">
            <h2>Inviter un membre</h2>
            <form class="invite-form">
                <div class="form-group" method="POST" action="sendInvitation.php">
                    <label for="email">Inviter par e-mail :</label>
                    <input type="email" id="email" placeholder="Entrez l'adresse e-mail">
                    <button type="button" class="btn">Envoyer</button>
                </div>

                <div class="form-group">
                    <label for="link">Copier le lien d'invitation :</label>
                    <input type="text" id="link" value="https://ourwebsite/exemple.lien" readonly>
                    <button type="button" class="btn icon-btn">
                        <img src="./images/copy.png" alt="Copy" class="icon-small">
                    </button>
                </div>

                <button type="button" class="btn finish-btn">Terminer</button>

                <div class="settings-icon">
                    <img src="./images/parameter.png" alt="Settings" />
                </div>
            </form>
        </div>
    </main>

    <?php require_once("footer.html"); ?> 
</body>
</html>