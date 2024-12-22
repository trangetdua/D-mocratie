	<?php 
		require_once("header.html");
		require_once("isConnected.php");
	?>
	<a href ="creer_groupe.php">
	<div class = "nouveauGroupe">
	<h2> Nouveau Groupe  </h2>
	<image src="./images/plus.png" alt="plus" id="plusGroupe"/>
	</div>
	</a>
	
	<h1> Mes groupes </h1>
	<?php 
		//$curl = curl_init('https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/utilisateur/?method=GET');
		$curl = curl_init('https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/apiTest.php/utilisateur/id_utilisateur/membre/id_groupe/groupe/id_Groupe/Thème/?method=GET');
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
		$data = json_decode(curl_exec($curl),true);
		foreach ($data as $value){
			if($value['Mail_Utilisateur']==$_SESSION['user_id'] && $value['Banni']==0){
				$color = $value['Couleur_Groupe'];
				echo "<div class='grp'style='background-color:$color'>";
				echo "<image class ='left' src='./images/iconImage.png' alt ='icon image'/>";
				echo "<h2>" . $value['Nom_Groupe'] . "</h2>";
				
				echo "<p> themes <p>";
			echo "</div>";
			}
		}
		//print_r($data);
	?>
	

	</body>
	</html>
