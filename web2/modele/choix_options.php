	<?php 
	require_once("../vue/header.php");

	if (!isset($_SESSION['fullname'])) {
		header("Location: ../vue/connection.php?error=notlogged");
		exit;
	}

	$fullname = $_SESSION['fullname'];

	?>
	<div id= "bigBox">
	<div class="boutonPropo">
		<a  href ="../vue/proposition.php"> 
		  <p>annuler</p>
		</a>
	</div>
		<?php
		$curl = curl_init('https://projets.iut-orsay.fr/saes3-aviau/TestProket/web2/controller/api.php/Proposition/?method=GET');
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
		$prop = json_decode(curl_exec($curl),true);
		foreach($prop as $p){
			if($p['id_proposition']==$_SESSION['proposition']){
				$titre = $p['Titre_Proposition'];
				echo '<h2 id ="titreProposition" >'.$titre.'</h2> ';
				
				echo '<p class="vote">'.	$p['Description_Proposition'] .'</p>';
			}
		}

			date_default_timezone_set('Europe/Paris');
			$dateActuelle = date('Y-m-d H:i:s');

			$url = "https://projets.iut-orsay.fr/saes3-aviau/TestProket/web2/controller/api.php/Vote/?method=POST";
			$data = [
            'Titre_Vote' => $titre,
            'Duree_vote' => $_POST['temps'],
			'Date_debut_vote'=>$dateActuelle,
            'valide' => 0,
			'id_proposition' => $_SESSION['proposition'],
			'id_type_vote' => $_POST['typeVote'],
			];
			
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
			curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

        $res = curl_exec($curl);		

        $response = json_decode($res, true);
			$id = $response['id'];
			$_SESSION['vote'] = $id;

			if($_POST['typeVote']==1){
				$url = "https://projets.iut-orsay.fr/saes3-aviau/TestProket/web2/controller/api.php/Choix/id/Oui/$id/?method=POST";
			
				$curl = curl_init($url);
				curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
				curl_exec($curl);
				
				$url = "https://projets.iut-orsay.fr/saes3-aviau/TestProket/web2/controller/api.php/Choix/id/Non/$id/?method=POST";
			
				$curl = curl_init($url);
				curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
				curl_exec($curl);
				
				header('Location:../vue/vote.php');

			}
			else if($_POST['typeVote']==2){
				 $url = "https://projets.iut-orsay.fr/saes3-aviau/TestProket/web2/controller/api.php/Choix/id/Pour/$id/?method=POST";
			
				$curl = curl_init($url);
				curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
				curl_exec($curl);
				
				$url = "https://projets.iut-orsay.fr/saes3-aviau/TestProket/web2/controller/api.php/Choix/id/Contre/$id/?method=POST";
			
				$curl = curl_init($url);
				curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
				curl_exec($curl);
				header('Location:../vue/vote.php');

			}
			else{
			echo '<form action="../vue/creer_options.php" method="post">';
			$nb=$_POST['nbOptions'];
			for($i=0;$i<$nb;$i++){
					$name = "choix".$i;
					echo '<label for="'.$name.'">'.$name.'</label>';
					echo '<input type="text" id="'.$name.'" name="'.$name .' "/>';
			}
			
			echo '<button id="boutonSuivant"> Suivant </button>';

			echo '</form>';
			}
	?>
	</div>
	<?php
	require_once("../vue/footer.html");

	?>
	
