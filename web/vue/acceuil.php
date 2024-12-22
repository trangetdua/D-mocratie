	<?php 
		require_once("header.html");
		require_once("isConnected.php");
	?>

	<a href ="creer_groupe.php">
	<div class = "nouveauGroupe">
	Nouveau Groupe <image src="./images/plus.png" alt="plus"/>
	</div>
	</a>
	<h1> Mes groupes </h1>
	<?php 
		$curl = curl_init('https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/utilisateur/?method=GET');
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
		$data = json_decode(curl_exec($curl),true);
		foreach ($data as $value){
			echo "<div class='grp'style='background-color:Teal'>";
				echo "<image class ='left' src='./images/iconImage.png' alt ='icon image'/>";
				echo "<h2>";
				echo $value['Login_Utilisateur'];
				echo "<h2/>";
				echo "<p> themes <p>";
			echo "</div>";
			
		}
		//print_r($data);
	?>
	

	</body>
	</html>
