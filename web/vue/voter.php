	<?php 
	require_once("header.php");

	if (!isset($_SESSION['fullname'])) {
		header("Location: connection.php?error=notlogged");
		exit;
	}

	$fullname = $_SESSION['fullname'];


			$id =$_POST['choix'];
			$user = $_SESSION['user_id']

				$url = "https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/choisi/$user/$id/?method=POST";
				$curl = curl_init($url);
				curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
				curl_exec($curl);
				header('Location:vote.php');

	require_once("footer.html");

	?>
	
