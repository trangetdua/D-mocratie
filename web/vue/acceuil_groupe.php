<?php 
		require_once("header.php");
	?>

<div id = "box">
<image src="./images/menuDepliant.png" alt="plus" class="js-expandmore" id="menu"/>
<div class = "js-to_expand">
<div id = "box">

	<p>Administrateur<p>
	</div>
	</div>
	</div>


<!--navigation-->
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

</div>

<a href ="creer_proposition.php">
<div style="margin-top:20px;" id="centered" class = "nouveauPropo">
 Nouvelle proposition <image src="./images/plus.png" alt="plus" id="plus"/>
</div>
</a>


<?php
	$curlPropos = curl_init('https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/utilisateur/id_utilisateur/membre/id_groupe/groupe/id_groupe/proposition?method=GET');
	curl_setopt($curlPropos,CURLOPT_RETURNTRANSFER,1);
	$propos = json_decode(curl_exec($curlPropos),true);
		foreach ($propos as $value){
				$titre = $value['Titre_Proposition'];
				$descr = $value['Description_Propostion'];
				echo "<div style='margin-top:20px;' id='centered' class = 'nouveauPropo'>";
				echo "<h2>$titre</h2>";
				echo $descr;
			echo "</div>";
		}




require_once("footer.html");
?>