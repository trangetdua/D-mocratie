	<?php 
		require_once("header.html");
	?>

	<button type = "button"> Nouveau groupe <image src="./images/plus.png" alt="plus"> </button>

	<h1> Mes groupes </h1>
	<?php 
		require_once("../controller/api.php");
		$json = api::getJson();
		echo $json;
	?>
	

	</body>
	</html>
