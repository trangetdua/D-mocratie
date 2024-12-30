	<?php 
		require_once("header.html");
		require_once("isConnected.php");
	?>
		

	<h1> Nouveau Groupe  </h1>
	<image src="./images/iconImage.png" alt="photo du groupe" id="ajouterPhotoGroupe"/>

	<form action="creation_groupe.php" method="post">
		<label> Nom du groupe : </label>
		<input name = "nom" id="nom" value="Nouveau_groupe"/>
		</label>
		<br>
		<br>
		<label> Couleur du groupe : </label>
		<select name = "couleur" id="couleur">
			<option value ="3a7ca5"> bleu </option>
			<option value ="0a9396"> vert </option>
			<option value ="780404"> rouge </option>
			<option value ="620581"> violet </option>
		</select>
		<br>
		<label> Thèmes : </label>
		<input name="Theme1" id="Theme1"/>
		<input name="Theme2" id="Theme2"/>
		<br>
		<button> C'est parti ! </button>


	 </form>
	<?php
		

		require_once("footer.html");

	?>
	
