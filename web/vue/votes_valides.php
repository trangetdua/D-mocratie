<?php 
		require_once("header.php");

		if (!isset($_SESSION['fullname'])) {
			header("Location: connection.php?error=notlogged");
			exit;
		}
	
		$fullname = $_SESSION['fullname'];


	?>

<main>
<?php
if($_SESSION['role'] == "administrateur"){
	echo "<a href='parametres.php'>";
	echo "<image src='./images/rouage.png' alt='parametre'  id='rouage'/>";
	echo "</a>";
}

?>

<div id="centered">

  <div class="nonactive">
    <a  href ="acceuil_groupe.php"> 
      <p>Propositions</p>
    </a>
  </div>

  <div class="nonactive" style="margin-left:20px;">
    <a  href ="votes_en_cours.php"> 
      <p>Votes en cours</p>
    </a>
  </div>
  
<div class="active" style="margin-left:20px;">
  <a href ="votes_valides.php"> 
    <p>Votes terminés</p>
  </a>
</div>
<div class="nonactive" style="margin-left:20px;">
    <a href="invitation.php"> 
      <p>Inviter un membre</p>
    </a>
  </div>
</div>




<?php
	$curlPropos = curl_init('https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/groupe/id_groupe/Proposition/id_proposition/Vote?method=GET');
	curl_setopt($curlPropos,CURLOPT_RETURNTRANSFER,1);
	$propos = json_decode(curl_exec($curlPropos),true);
		date_default_timezone_set('Europe/Paris');
			$dateActuelle = date('Y-m-d H:i:s');
			$dateActuelle=date_create($dateActuelle);
		foreach ($propos as $value){
			
			if( $value['Id_Groupe'] == $_SESSION['groupe']){
				$dateVote = $value['Date_debut_vote'];
				$duree = $value['Duree_Vote'];
				$dateVote=date_create($dateVote);
				$diff=date_diff($dateVote,$dateActuelle);
				$temps = $diff->format("%R%a ")+$duree;
				if($temps <=0){
				$link = "transition_vote1.php?id=".$value['Id_Vote'];
				$titre = $value['Titre_Vote'];
				$descr = $value['Description_Proposition'];
				echo "<a href=$link>";
				echo "<div  id='centeredColumn' class = 'Propo'>";
				echo "<div><h2>$titre</h2> </div>";
				echo "<div><p>$descr</p></div>";
			echo "</div>";
			echo "</a>";
			}
			}
		}


echo "</main>";

require_once("footer.html");
?>