<?php
require_once("header.html");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Suppression</title>
    <link rel="stylesheet" href="./css/styleS.css">
</head>
<body>
<div class="container-suppression">

    <img src="./images/sad.png" alt="Icon triste" class="sad-icon">

    <h1>Voulez-vous supprimer votre compte ?</h1>
    <p>
      Cette action est irréversible et toutes vos données seront perdues.<br>
      Confirmez-vous cette décision ?
    </p>

    <div class="btn-group">
      
      <form action="delete.php" method="post" style="display:inline;">
        <button type="submit" class="btn-supprimer">Supprimer</button>
      </form>

      <form action="profil.php" style="display:inline;">
        <button type="submit" class="btn-annuler">Annuler</button>
      </form>
    </div>
  </div>
</body>

<?php require_once("footer.html"); ?>

</html>