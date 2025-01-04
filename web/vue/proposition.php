<?php 
		require_once("header.php");

		if (!isset($_SESSION['fullname'])) {
			header("Location: connection.php?error=notlogged");
			exit;
		}
	
		$fullname = $_SESSION['fullname'];
	?>

<main>




<div id= "bigBox"> <!--la boite bleu de la proposition -->
	<div class = 'centered'>
	<image src="./images/troisPoints.png" alt="plus" class="js-expandmore" id="expand" style="margin-top : 2px"/>
		<div class = "js-to_expand">
			<div class="boutonSignal">
				<p>Signaler</p><!--incrementer une variable-->
			</div>
		</div>

<a  href ="acceuil_groupe.html"> 
	<div class="boutonPropo">
		  <p>retour</p>
	</div>
</a>

	<div class="boutonPropo"> <!--incrementer une variable-->
		  <p>demander un vote</p>
	</div>
	<div >
	
	<?php
	$curlPropos = curl_init('https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/Proposition?method=GET');
	curl_setopt($curlPropos,CURLOPT_RETURNTRANSFER,1);
	$propos = json_decode(curl_exec($curlPropos),true);
	$titre;
	$texte;	
	foreach ($propos as $value){
			if($value['id_proposition']==$_SESSION['proposition']){
				$titre = $value['Titre_Proposition'];
				$texte = $value['Description_Proposition'];
			}
		}
	echo "<h1 id ='text'>$titre</h1> ";
	

	echo "<div>";

	$curlUti = curl_init('https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/utilisateur?method=GET');
	curl_setopt($curlUti,CURLOPT_RETURNTRANSFER,1);
	$utis = json_decode(curl_exec($curlUti),true);
		foreach ($utis as $value){
			if($value['Mail_Utilisateur']==$_SESSION['user_id']){
				$nom = $value['Nom_Utilisateur'];
				$prenom = $value['Prenom_Utilisateur'];
			}
		}
	
		echo  "<h6 id ='text' class='js-expandmore'>";
		echo  "<image src='./images/pdpUtilisateur.png' alt='photo de profil utilisateur' id='plus' class = propo></image>";
		echo  "$prenom $nom</h6>";
		echo  "<div class = 'js-to_expand'>";
		echo  "<div class='boutonSignalNom'>";
		echo  "<p>Signaler</p>";
		echo  "</div>";
		echo  "</div>";
		echo  "</div>";

	

		echo  "<div class = text> ";
		echo  "<h5 id ='text'>$texte</h5> ";
		echo  "</div>";

		?>

	<div id="interagir" > 
	<a href ="propositionCommentaire.php">
	<image src="./images/commentaire.png" alt="bulle de commentaire" class="js-expandmore" style = 'width:55px; height:55px;'/>
	</a>

	<image src="./images/reaction.png" alt="reactions" class="js-expandmore" style = 'width:55px; height:55px;'/>
	<div class = "js-to_expand">
		<div class="reaction">
			<table>
				<tbody>
					<?php
					$curlemoji = curl_init('https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/emoticone?method=GET');
					curl_setopt($curlemoji,CURLOPT_RETURNTRANSFER,1);
					$emojis = json_decode(curl_exec($curlemoji),true);
					$num =0;
					for ($i = 0; $i<3 ; $i++){
						echo  "<tr>";
						for ($j = 0; $j<3 ; $j++){
							$source = $emojis[$num]['Image_Emo'];
							echo  "<td>";
							echo  "<image src='$source' alt='reactions'  id='emoji'/> ";
							$num = $num +1;
							echo  "</td>";
						}
						echo  "</tr>";
					}
					?>


				</tbody>
			</table>
			
		</div>
	</div>
	
	</div>

	</div>
	</div>







</main>
<?php
require_once("footer.html");
?>