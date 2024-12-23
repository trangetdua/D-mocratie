	<?php 
		require_once("header.html");
		require_once("isConnected.php");
	?>
		

	<h1> Nouveau Groupe  </h1>
	<image src="./images/iconImage.png" alt="photo du groupe" id="ajouterPhotoGroupe"/>

	<form>
		<label> Nom du groupe : </label>
		<input name = "nom" />
		</label>
		<br>
		<label> Couleur (code HEX avec # devant, par exemple #2f6690) : </label>
		<input name = "couleur" />
		</label>
		<br>
		<label> Thèmes : </label>
		<input name="Theme1"/>
		<input name="Theme2"/>
		<br>
		</label>
		<button> C'est parti ! </button>
	 </form>
	<?	
		require_once("footer.html");

	?>
	
