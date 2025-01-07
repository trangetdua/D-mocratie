<?php 
		require_once("header.php");

		if (!isset($_SESSION['fullname'])) {
			header("Location: connection.php?error=notlogged");
			exit;
		}
	
		$fullname = $_SESSION['fullname'];

		if (isset($_GET['group_id']) && !empty($_GET['group_id'])) {
			$groupName = trim($_GET['group_id']);
		} else {
			// utiliser session s'il manque id
			if (!isset($_SESSION['groupe']) || empty($_SESSION['groupe'])) {
				echo "Erreur: Aucun groupe sélectionné.";
				exit;
			}
			$groupName = $_SESSION['groupe'];
		}

	?>

<main>
<?php
if($_SESSION['role'] = "administrateur"){
	echo "<a href='parametres.php'>";
	echo "<image src='./images/rouage.png' alt='parametre'  id='rouage'/>";
	echo "</a>";
}

?>

<div id="centered">

  <div class="active">
    <a  href ="proposition.php"> 
      <p>Propositions</p>
    </a>
  </div>

  <div class="nonactive" style="margin-left:20px;">
    <a  href ="votes_en_cours.php"> 
      <p>Votes en cours</p>
    </a>
  </div>
  
<div class="nonactive" style="margin-left:20px;">
  <a href ="votes_valides.php"> 
    <p>Votes validés</p>
  </a>
</div>
<div class="nonactive" style="margin-left:20px;">
    <a href="invitation.php"> 
      <p>Inviter un membre</p>
    </a>
  </div>
</div>

<a href ="creer_proposition.php">
<div style="margin-top:20px;" id="centered" class = "nouveauPropo">
 Nouvelle proposition <image src="./images/plus.png" alt="plus" id="plus"/>
</div>
</a>


<?php
	$curlPropos = curl_init('https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/groupe/id_groupe/Proposition?method=GET');
	curl_setopt($curlPropos,CURLOPT_RETURNTRANSFER,1);
	$propos = json_decode(curl_exec($curlPropos),true);
		foreach ($propos as $value){
			if($value['Nom_Groupe'] === $groupName || $value['Id_Groupe'] == $groupName){
				$link = "transition_propo.php?id=".$value['id_proposition'];
				$titre = $value['Titre_Proposition'];
				$descr = $value['Description_Proposition'];
				echo "<a href=$link>";
				echo "<div  id='centeredColumn' class = 'Propo'>";
				echo "<div><h2>$titre</h2> </div>";
				echo "<div><p>$descr</p></div>";
			echo "</div>";
			echo "</a>";
			}
		}


echo "</main>";

require_once("footer.html");
?>