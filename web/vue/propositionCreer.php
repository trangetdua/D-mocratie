<?php 
require_once("header.php");
?>





<div id= "bigBox"> <!--la boite bleu de la proposition -->
	<div class = 'centered'>

	<div class="boutonPropo">
		<a  href ="acceuil_groupe.html"> 
		  <p>Annuler</p>
		</a>
	</div>
	<div >
		
	<h1 id ='text'>Ma Proposition</h1> 

		<div>
		<h6 id ='text' >
		<image src="./images/pdpUtilisateur.png" alt="photo de profil utilisateur" id="plus" class = propo></image>
		moi</h6>
		</div>


		<form action="creation_proposition.php" method="post">
			
			<div class = 'textCreation'>
				<label for="nom"> </label>
				<textarea  id="nom" name="nom">nom de ma proposition...</textarea>
				
			</div>
			<div class = 'textCreation'>
				<label for="contenue"> </label>
				<textarea  id="contenue" name="contenue">Description de ma proposition...</textarea>
				
			</div>

				
			<br>
		<label> Thèmes : </label>
		<input name="Theme" id="Theme"/>
		<br>
			
		<button id="boutonParti"> Publier </button>
			
		</form>


</div>






<?php
		

		require_once("footer.html");

	?>