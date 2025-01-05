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
		<a  href ="proposition.php"> 
		  <p>valider le vote</p>
		</a>
	</div>

	<div class="boutonPropo">
		<a  href ="proposition.php"> 
		  <p>retour</p>
		</a>
	</div>
		<?php
		$_SESSION['vote']=1;
			$curl = curl_init('https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/Vote/id_proposition/Proposition/?method=GET');
			curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
			$infos = json_decode(curl_exec($curl),true);
			foreach($infos as $info){
				if($info['Id_Vote']==$_SESSION['vote']){
					echo '<h2 id ="titreProposition" >'. $info['Titre_Proposition'] .'</h2> ';
					echo '<p class="vote">'. $info['Description_Proposition'] .'</p>';
					$dateVote = $info['Date_debut_vote'];
					$duree = $info['Duree_Vote'];
				}
			}
		$curl = curl_init('https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/utilisateur/id_utilisateur/choisi/id_choix/Choix/?method=GET');
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
		$verif = json_decode(curl_exec($curl),true);
		$premierVote = true;
		$vote = "null";
		foreach($verif as $v){
				if($v['Id_Vote']==$_SESSION['vote']&&$_SESSION['user_id']==$v['Id_Utilisateur']){
					$premierVote = false;
					$vote=$v['Nom_Choix'];
				}
		}
		if($premierVote){
			date_default_timezone_set('Europe/Paris');
			$dateActuelle = date('Y-m-d H:i:s');
			$diff=date_diff($dateVote,$dateActuelle);
			$temps = $diff->format("%R%a ")-$duree;
			if ($temps > 0){
   

				echo '<form action="voter.php" method="post">';
				echo '<div class="choix">';
				echo '<label for="choix"> Votre avis : </label>';
				echo '<select name = "choix" id="choix">';
		

			$curl = curl_init('https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/vote/id_vote/Choix/?method=GET');
			curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
			$choix = json_decode(curl_exec($curl),true);	
			foreach($choix as $info){
				if($info['Id_Vote']==$_SESSION['vote']){
							echo "<option value = ". $info['Id_choix'] .">" . $value['nom_choix'] ."</option>";
				}
			}
		

		echo '</select>';
		echo '</div>';
		echo '<button id="boutonVoter"> Voter </button>';

		echo '</form>';
			}
			else{
				echo '<p> Ce vote est terminé. </p>';

			}
		}else{
			echo '<p> Vous avez déjà voté : '.$vote.'</p>';
		}
		echo '<p> Temps restant : '.$temps .' jours </p>';
		echo '</div>';
	require_once("footer.html");

	?>
	
