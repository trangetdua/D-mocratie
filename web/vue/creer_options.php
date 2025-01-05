	<?php 
	require_once("header.php");

	if (!isset($_SESSION['fullname'])) {
		header("Location: connection.php?error=notlogged");
		exit;
	}

	$fullname = $_SESSION['fullname'];


			 $id =$_SESSION['vote'];

			for($i=0;$i<count($_POST);i++){
				$j=$i+2;
				$name = "choix".$j;
				$url = "https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/Choix/id/$_POST[$name]/$id/?method=POST";
				$curl = curl_init($url);
				curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
				curl_exec($curl);
			}
				header('Location:vote.php');

	require_once("footer.html");

	?>
	
