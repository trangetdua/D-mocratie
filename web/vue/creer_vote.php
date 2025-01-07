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
	<?php 
		$curl = curl_init('https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/Vote?method=GET');
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
		$verif = json_decode(curl_exec($curl),true);
		foreach($verif as $v){
			if($v['id_proposition']==$_SESSION['proposition']){
				$_SESSION['vote']=$v['Id_Vote'];
				header('Location:vote.php');
			}
		}

		$curl = curl_init('https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/Proposition/?method=GET');
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
		$prop = json_decode(curl_exec($curl),true);
		foreach($prop as $p){
			if($p['id_proposition']==$_SESSION['proposition']){
				
				echo '<h2 id ="titreProposition" >'.$p['Titre_Proposition'].'</h2> ';
				echo '<p class="vote">'.	$p['Description_Proposition'] .'</p>';
			}
		}
		?>
		<form action="choix_options.php" method="post">
		<div class="vote">

		<label for="typeVote"> Type de vote : </label>

		<select name = "typeVote" id="typeVote">
		
		<?php
			$curl = curl_init('https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/type_vote/?method=GET');
			curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
			$types = json_decode(curl_exec($curl),true);
			foreach($types as $value){
				echo "<option value = ". $value['Id_Type_vote'] .">" . $value['Nom_Type_Vote'] ."</option>";
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
	
