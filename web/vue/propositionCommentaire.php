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
if($_SESSION['role'] = "administrateur"){
	echo "<a href='parametres.php'>";
	echo "<image src='./images/rouage.png' alt='parametre'  id='rouage'/>";
	echo "</a>";
}

?>


<div id= "bigBox"> <!--la boite bleu de la proposition -->
	<div class = 'centered'>
	<image src="./images/troisPoints.png" alt="plus" class="js-expandmore" id="expand" style="margin-top : 2px"/>
		<div class = "js-to_expand">
			<?php
			$link = "signalement.php?page=propositionCommentaire&nom=id_proposition&table=Proposition&id=".$_SESSION['proposition'];
			echo "<a href = $link>";
			?>
			<div class="boutonSignal">
				<p>Signaler</p><!--incrementer une variable-->
			</div>
			</a>
		</div>

	<div class="boutonPropo">
		<a  href ="acceuil_groupe.php"> 
		  <p>Retour</p>
		</a>
	</div>

	<div class="boutonPropo">
		<a  href ="proposition.php"> <!--incrementer une variable-->
		  <p>demander un vote</p>
		</a>
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
	
		echo  "<h6 id ='text' >";
		echo  "<image src='./images/pdpUtilisateur.png' alt='photo de profil utilisateur' id='plus' class = propo></image>";
		echo  "$prenom $nom</h6>";
		
		echo  "</div>";
		?>

	<div id = 'boiteCommentaire'>

		<a href ="proposition.php">
		<div class="boutonComment">
			<a  href ="proposition.php"> 
			  <p>Retour</p>
			</a>
		</div>
		</a>

		<h1 id ='text'>Commentaire</h1> 


		<form action="creation_commentaire.php" method="post">
			
			<div type="submit" class="boutonComment">
						<button id="boutonComment"> Publier </button>
			</div>
			
			<div>
				<label for="commentaire"></label>
				<textarea id="commentaire" name="commentaire"></textarea>
				
			</div>

			
		  </form>

		<?php
		
		  $curlCom = curl_init('https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/commentaire?method=GET');
	curl_setopt($curlCom,CURLOPT_RETURNTRANSFER,1);
	$coms = json_decode(curl_exec($curlCom),true);
		
		echo '<table>';
			echo '<tbody>';
				foreach ($coms as $value){
					if($value['id_proposition']==$_SESSION['proposition']){
						$contenue = $value['Contenue_Commentaire'];
				echo "<tr>";
					echo "<td>";
						echo "<image src='./images/pdpUtilisateur.png' alt='reactions'  id='emoji'/> ";
					echo "</td>";

					echo "<td style = 'width: 100%'>";
						echo "<p>$contenue</p>";
					echo "</td>";

					echo "<td>";
						echo "<image src='./images/troisPoints.png' alt='plus' class='js-expandmore' id='expand' style='margin-top : 2px'/>";
						echo "<div class = 'js-to_expand'>";
							echo "<div class='boutonSignal'>";
							$link = "signalement.php?page=propositionCommentaire&nom=Id_commentaire&table=commentaire&id=".$value['Id_commentaire'];
							echo "<a href = $link>";
			
								echo "<p>Signaler</p>";
							echo "</div>";
							echo "</a>";
							echo "</div>";
					echo "</td>";

				echo "</tr>";
					}
				}
				?>
			</tbody>
		</table>
	</div>

	</div>
	</div>



	</main>
<?php
require_once("footer.html");
?>