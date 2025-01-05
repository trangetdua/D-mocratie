<?php
require_once("header.php");
    
    if (!isset($_SESSION['user_id'])) {
        header("Location: connection.php?error=notlogged");
        exit;
    }
    
    $fullname = $_SESSION['fullname'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inviter un membre</title>
    <link rel="stylesheet" href="./css/styleI.css">
</head>
<body>
<main class="container" style="min-height: unset !important;" >
        <div class="form-wrapper">
            <h2>Inviter un membre</h2>

            <?php
            if (isset($_GET['success']) && $_GET['success'] == 'invitation_sent') {
                echo "<p style='color: green;'>Invitation envoyée avec succès!</p>";
            }
            if (isset($_GET['error'])) {
                $error = $_GET['error'];
                switch($error) {
                    case 'empty_email':
                        echo "<p style='color: red;'>Veuillez entrer une adresse e-mail.</p>";
                        break;
                    case 'invalid_email':
                        echo "<p style='color: red;'>Adresse e-mail invalide.</p>";
                        break;
                    case 'database_error':
                        echo "<p style='color: red;'>Erreur de base de données. Veuillez réessayer plus tard.</p>";
                        break;
                    case 'user_not_found':
                        echo "<p style='color: red;'>Utilisateur non trouvé.</p>";
                        break;
                    case 'invitation_already_sent':
                        echo "<p style='color: red;'>Une invitation a déjà été envoyée à cette adresse e-mail.</p>";
                        break;
                    default:
                        echo "<p style='color: red;'>Une erreur inconnue est survenue.</p>";
                        break;
                }
            }
        ?>

            <form class="invite-form"  method="POST" action="sendInvitation.php">
                <div class="form-group">
                    <label for="email">Inviter par e-mail :</label>
                    <input type="email" id="email" name="email" placeholder="Entrez l'adresse e-mail">
                    <button type="submit" class="btn">Envoyer</button>
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

<script>
function copyInvitationLink() {
    var copyText = document.getElementById("link");
    copyText.select();
    copyText.setSelectionRange(0, 99999); /* For mobile devices */

    navigator.clipboard.writeText(copyText.value).then(function() {
        alert("Lien d'invitation copié: " + copyText.value);
    }, function(err) {
        alert("Erreur lors de la copie du lien: ", err);
    });
}
</script>

</html>