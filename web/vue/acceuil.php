	<?php 
	require_once("header.php");

	if (!isset($_SESSION['fullname'])) {
		header("Location: connection.php?error=notlogged");
		exit;
	}

	$fullname = $_SESSION['fullname'];

	if (!isset($_SESSION['groupe']) || !is_array($_SESSION['groupe'])) {
		$_SESSION['groupe'] = [];
	}

	?>
	<a href ="creer_groupe.php">
	<div class = "nouveauGroupe">
	<h2> Nouveau Groupe  </h2>
	<image src="./images/plus.png" alt="plus" id="plusGroupe"/>
	</div>
	</a>
	
	<h1> Mes groupes </h1>
	<?php 
		$curlGroupes = curl_init('https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/utilisateur/id_utilisateur/membre/id_groupe/groupe/?method=GET');
		curl_setopt($curlGroupes,CURLOPT_RETURNTRANSFER,1);
		$groupes = json_decode(curl_exec($curlGroupes),true);

		$curlThemes = curl_init('https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/groupe/id_groupe/Thème/?method=GET');
		curl_setopt($curlThemes,CURLOPT_RETURNTRANSFER,1);
		$themes = json_decode(curl_exec($curlThemes),true);

		$groupIdsFromAPI = [];

		foreach ($groupes as $value){
			if($value['Mail_Utilisateur']==$_SESSION['user_id'] && $value['Banni']==0){

				$groupIdsFromAPI[] = $value['Id_Groupe'];

				$color = "#" .$value['Couleur_Groupe'];
				$link = "transition_groupe.php?id=".$value['Id_Groupe'];
				echo "<a href=$link>";
				echo "<div class='grp'style='background-color:$color'>";
				echo "<image class ='photoGroupe' src='./images/iconImage.png' alt ='icon image'/>";
				echo "<image class ='menuNotificationGroupe' src='./images/troisPoints.png' alt = 'menu de notification'/>";
				echo "<h2>" . $value['Nom_Groupe'] . "</h2>";
				foreach($themes as $t){
					echo "<div class='theme'>";
					if($value['Id_Groupe']==$t['Id_Groupe']){
						echo "<p>" . $t['Nom_Theme']. "<p>";
					}
					echo "</div>";
				}
			echo "</div>";
			echo "</a>";
			}
		}

		foreach ($_SESSION['groupe'] as $groupId) {
			if (!in_array($groupId, $groupIdsFromAPI)) { 
				echo "<a href='transition_groupe.php?id=$groupId'>";
				echo "<div class='grp' style='background-color:#ccc'>";
				echo "<img class='photoGroupe' src='./images/iconImage.png' alt='icon image'/>";
				echo "<h2>New Group (ID: $groupId)</h2>";
				echo "</div>";
				echo "</a>";
			}
		}
		//print_r($data);
		require_once("footer.html");

	?>
	
