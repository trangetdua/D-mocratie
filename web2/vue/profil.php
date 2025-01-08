<?php
require_once("header.php");

if (!isset($_SESSION['fullname'])) {
  header("Location: connection.php?error=notlogged");
  exit;
}

$fullname = $_SESSION['fullname'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profil</title>
    <link rel="stylesheet" href="./css/styleP.css">
</head>
<body>
  <div class="page-container">
    <div class="sidebar">

      <div class="avatar"></div>
      <div class="user-name"><?php echo htmlspecialchars($fullname); ?></div>

      <div class="search-container">
        <input type="text" placeholder="Chercher une paramètre..." />
        <span class="search-icon">🔍</span>
      </div>

      <div class="menu">
        <ul>
          <li>Informations personnelles</li>
          <li>Mes votes</li>
          <li>Mes groupes</li>
          <li>Comptes</li>
          <li>Sécurité & Privé</li>
          <li>Langages</li>
        </ul>
      </div>
    </div>

    <div class="content">

      <div class="profile-header">
        <div class="big-avatar"></div>
        <div>
          <h2><?php echo htmlspecialchars($fullname); ?></h2>
        </div>
      </div>

      <div class="info-card">
        <img src="./images/pdpUtilisateur.png" alt="icon user" class="icon">
        <div>
          <h3>Email & Comptes</h3>
          <p>Changer le mot de passe, gérer le compte,...</p>
        </div>
      </div>

      <div class="actions">
        <div class="action-item delete">
          <img src="https://cdn-icons-png.flaticon.com/512/1828/1828843.png" alt="delete icon" />
          <a href="suppression.php">Supprimer le compte</a>
        </div>

        <div class="action-item">
          <img src="https://cdn-icons-png.flaticon.com/512/992/992651.png" alt="add user icon" />
          <a href="register.php">Ajouter un autre compte</a>
        </div>

        <div class="action-item">
          <img src="https://cdn-icons-png.flaticon.com/512/159/159707.png" alt="logout icon" />
          <a href="connection.php"> Se déconnecter</a>
        </div>
      </div>
  </div>
</div>

</body>

<?php require_once("footer.html"); ?>

</html>