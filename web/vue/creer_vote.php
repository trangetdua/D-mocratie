	<?php 
	require_once("header.php");

	if (!isset($_SESSION['fullname'])) {
		header("Location: connection.php?error=notlogged");
		exit;
	}

	$fullname = $_SESSION['fullname'];

	?>
	<div id= "bigBox">
			

	<div class="boutonPropo">
		<a  href ="proposition.php"> <!--incrementer une variable-->
		  <p>annuler</p>
		</a>
	</div>

		<h2 id ="titreProposition" >Proposition 1</h2> 
		<p class="vote"> Description de ma proposition Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nos... </p>
		<form action="choix_options.php" method="post">
		<div class="vote">

		<label for="typeVote"> Type de vote : </label>

		<select name = "typeVote" id="typeVote">
		
		<?php
			$curl = curl_init('https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/type_vote/?method=GET');
			curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
			$types = json_decode(curl_exec($curl),true);
			foreach($types as $value){
				echo "<option value = ". $value['Id_Type_Vote'] .">" . $value['Nom_Type_Vote'] ."</option>";
			}
			?>
		</select>
		</div>
		<div class="vote">
		<label for="nbOptions"> Si il s'agit d'un vote avec plus de deux options, nombres d'options qu'aura votre vote: </label>
		<input type="number" id="nbOptions" name="nbOptions" min="2" max="10" value="2" />
		</div>
			<label for="temps">Durée du vote (en jours) </label>
			<input type="number" id="temps" name="temps" min="1" value="7" />

		<button id="boutonSuivant"> Suivant </button>

	 </form>

	</div>
	<?php
	require_once("footer.html");

	?>
	
