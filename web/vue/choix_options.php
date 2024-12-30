	<?php 
	require_once("header.html");
	require_once("isConnected.php");

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
		<p id="textProposition"> Description de ma proposition Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nos... </p>
		<form>

		<select name = "typeVote" id="typeVote">
		<?php
			$curl = curl_init('https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/type_vote/?method=GET');
			curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
			$types = json_decode(curl_exec($curl),true);
			foreach($types as $value){
				echo "<option value = ". $value['Id_Type_Groupe'] .">" . $value['Nom_Type_Groupe'] ."</option>";
			?>
		<label for="nbOptions">Si il s'agit d'un vote avec plus de deux options, nombres d'options qu'aura votre vote:</label>
		<input type="number" id="nbOptions" name="nbOptions" min="2" max="10" value="2" />

		</select>
	 </form>

	</div>
	<?php
	require_once("footer.html");

	?>
	
