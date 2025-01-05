	<?php 
	require_once("header.php");

	if (!isset($_SESSION['fullname'])) {
		header("Location: connection.php?error=notlogged");
		exit;
	}

	$fullname = $_SESSION['fullname'];

	?>
	<a href ="acceuil.php">
	<div class = "nouveauGroupe">
	<h2> Retour  </h2>
	</div>
	</a>
	
	<h1> Signalements </h1>
	<h2> Propositons <h2>
	<table>
		<tr>
			<th> Id Proposition </th>
			<th> Titre </th>
			<th> Auteur </th>
			<th> Signalements </th>
		</tr>
	<?php 
		$curlPropositions = curl_init('https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/Proposition/id_utilisateur/utilisateur/?method=GET');
		curl_setopt($curlPropositions,CURLOPT_RETURNTRANSFER,1);
		$propo = json_decode(curl_exec($curlPropositions),true);
		
		$_SESSION['groupe']=1;
		foreach ($propo as $p){
			if($p['Id_Groupe']==$_SESSION['groupe'] && $p['Signaler']>0){
				echo '<tr>';
				echo '<td>' . $p['id_proposition'] . '</td>';
				echo '<td>' . $p['Titre_Proposition'] . '</td>';
				echo '<td>' . $p['Nom_Utilisateur']. ' ' .$p['Prenom_Utilisateur'] . '</td>';
				echo '<td>' . $p['Signaler'] . '</td>';
				echo '</tr>';
				echo '<div class="boutonPropo">';
				echo '<a  href ="proposition.php"> ';
				echo '<p>supprimer</p>';
				echo '</a>';
				echo '</div>';
			}
		}
	?>
	</table>
	<h2> Commentaires <h2>
	<table>
		<tr>
			<th> Id Commentaire </th>
			<th> Commentaire </th>
			<th> Auteur </th>
			<th> Proposition </th>
			<th> Signalements </th>

		</tr>
	<?php 
		$curlCom = curl_init('https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/utilisateur/id_utilisateur/commentaire/id_proposition/Proposition/?method=GET');
		curl_setopt($curlCom,CURLOPT_RETURNTRANSFER,1);
		$com = json_decode(curl_exec($curlCom),true);
		
		foreach ($com as $c){
			if($c['Id_Groupe']==$_SESSION['groupe'] && $c['Signaler']>0){ 
				echo '<tr>';
				echo '<td>' . $c['Id_commentaire'] . '</td>';
				echo '<td>' . $c['Contenue_Commentaire'] . '</td>';
				echo '<td>' . $c['Nom_Utilisateur']. ' ' .$c['Prenom_Utilisateur'] . '</td>';
				echo '<td>' . $c['Titre_Proposition']. '</td>';
				echo '<td>' . $c['Signaler'] . '</td>';
				echo '</tr>';
			}
		}
		echo '</table>';

	


		require_once("footer.html");

	?>
	
