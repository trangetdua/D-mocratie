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
		  <p>annuler</p>
		</a>
	</div>
		<h2 id ="titreProposition" >Proposition 1</h2> 
		<p id="textProposition"> Description de ma proposition Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nos... </p>
		<?php
			$url = "https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/groupe/?method=POST";
			$data = [
            'Titre_vote' => REPLACE,
            'Duree_vote' => $_POST['temps'],
            'valide' => false,
			'id_proposition' => REPLACE,
			'id_type_vote' => $_POST['typeVote'],
			];
			
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
			curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

			$response = json_decode(curl_exec($curl), true);
			$id = $response['id'];
			$_SESSION['vote'] = $id;

			if($_POST['typeVote']==1){
				$url = "https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/choix/id/Oui/$id/?method=POST";
			
				$curl = curl_init($url);
				curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
				curl_exec($curl);
				
				$url = "https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/choix/id/Non/$id/?method=POST";
			
				$curl = curl_init($url);
				curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
				curl_exec($curl);
				
				header('Location:vote.php');

			}
			else if($_POST['typeVote']==2){
				 $url = "https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/choix/id/Pour/$id/?method=POST";
			
				$curl = curl_init($url);
				curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
				curl_exec($curl);
				
				$url = "https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/choix/id/Contre/$id/?method=POST";
			
				$curl = curl_init($url);
				curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
				curl_exec($curl);
				header('Location:vote.php');

			}
			else{
			echo '<form action="creer_options.php" method="post">';

			for($i=2;i<POST['nbOptions'];i++){
					$name = "choix".$i;
					echo '<label for="'.$name.'">'.$name.'</label>';
					echo '<input type="text" id="'.$name.'" name="'.$name .' />';
			}
			echo '<button id="boutonSuivant"> Suivant </button>';
			echo '</form>';
	?>
	</div>
	<?php
	require_once("footer.html");

	?>
	
